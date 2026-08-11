const { Telegraf, Markup } = require('telegraf');
const axios = require('axios');
require('dotenv').config();

const requiredEnvironment = ['BOT_TOKEN', 'LARAVEL_API_URL', 'API_TOKEN'];
const missingEnvironment = requiredEnvironment.filter((name) => !process.env[name]);

if (missingEnvironment.length > 0) {
    throw new Error(`Missing environment variables: ${missingEnvironment.join(', ')}`);
}

const bot = new Telegraf(process.env.BOT_TOKEN);
const api = axios.create({
    baseURL: process.env.LARAVEL_API_URL.replace(/\/$/, ''),
    timeout: 10000,
    headers: {
        Authorization: `Bearer ${process.env.API_TOKEN}`,
        Accept: 'application/json',
    },
});

function mainKeyboard() {
    return Markup.keyboard([
        ['Статус уведомлений'],
        ['Мой Telegram ID'],
    ]).resize();
}

function profilePayload(ctx) {
    return {
        telegram_id: ctx.from.id,
        first_name: ctx.from.first_name || null,
        last_name: ctx.from.last_name || null,
        username: ctx.from.username || null,
    };
}

function profileLabel(ctx) {
    return ctx.from.username ? `@${ctx.from.username}` : `ID ${ctx.from.id}`;
}

function statusMessage(statuses) {
    const enabled = Boolean(statuses.enabled ?? statuses.ua ?? statuses.dubai);

    return [
        `Уведомления этого сайта: ${enabled ? '✅ включены' : '❌ выключены'}`,
        '',
        'Изменить подписку может администратор сайта.',
    ].join('\n');
}

function logApiError(context, error) {
    console.error(context, {
        status: error.response?.status,
        message: error.response?.data?.message || error.message,
    });
}

async function registerProfile(ctx) {
    const response = await api.post('/api/store-user', profilePayload(ctx));

    return response.data;
}

async function fetchStatuses(ctx) {
    await registerProfile(ctx);

    const response = await api.get('/api/user/regions', {
        params: { telegram_id: ctx.from.id },
    });

    return response.data.statuses;
}

bot.start(async (ctx) => {
    try {
        const data = await registerProfile(ctx);

        await ctx.reply(
            [
                `Telegram-профиль ${profileLabel(ctx)} подключён.`,
                'Теперь администратор может выбрать вас в настройках уведомлений сайта.',
                '',
                statusMessage(data.statuses),
            ].join('\n'),
            mainKeyboard(),
        );
    } catch (error) {
        logApiError('Telegram profile registration failed.', error);
        await ctx.reply('Не удалось подключить профиль. Попробуйте позже.', mainKeyboard());
    }
});

bot.command('status', async (ctx) => {
    try {
        await ctx.reply(statusMessage(await fetchStatuses(ctx)), mainKeyboard());
    } catch (error) {
        logApiError('Telegram status request failed.', error);
        await ctx.reply('Не удалось получить статус уведомлений. Попробуйте позже.', mainKeyboard());
    }
});

bot.hears('Статус уведомлений', async (ctx) => {
    try {
        await ctx.reply(statusMessage(await fetchStatuses(ctx)), mainKeyboard());
    } catch (error) {
        logApiError('Telegram status request failed.', error);
        await ctx.reply('Не удалось получить статус уведомлений. Попробуйте позже.', mainKeyboard());
    }
});

bot.hears('Настройка региона', async (ctx) => {
    try {
        await ctx.reply(statusMessage(await fetchStatuses(ctx)), mainKeyboard());
    } catch (error) {
        logApiError('Legacy Telegram status request failed.', error);
        await ctx.reply('Не удалось получить статус уведомлений. Попробуйте позже.', mainKeyboard());
    }
});

bot.action(/toggle_(dubai|ua)/, async (ctx) => {
    await ctx.answerCbQuery('Подписками теперь управляет администратор сайта.');

    try {
        await ctx.editMessageReplyMarkup({ inline_keyboard: [] });
        await ctx.reply(statusMessage(await fetchStatuses(ctx)), mainKeyboard());
    } catch (error) {
        logApiError('Legacy Telegram region button handling failed.', error);
        await ctx.reply('Не удалось получить актуальный статус. Попробуйте позже.', mainKeyboard());
    }
});

bot.command('id', (ctx) => {
    ctx.reply(`Ваш Telegram ID: ${ctx.from.id}\nПрофиль: ${profileLabel(ctx)}`, mainKeyboard());
});

bot.hears('Мой Telegram ID', (ctx) => {
    ctx.reply(`Ваш Telegram ID: ${ctx.from.id}\nПрофиль: ${profileLabel(ctx)}`, mainKeyboard());
});

bot.on('text', (ctx) => {
    ctx.reply('Используйте кнопки «Статус уведомлений» или «Мой Telegram ID».', mainKeyboard());
});

bot.catch((error, ctx) => {
    console.error('Unhandled Telegram bot error.', {
        update_id: ctx.update?.update_id,
        message: error.message,
    });
});

bot.launch()
    .then(() => console.log('Бот запущен'))
    .catch((error) => {
        console.error('Bot launch failed.', error.message);
        process.exitCode = 1;
    });

process.once('SIGINT', () => bot.stop('SIGINT'));
process.once('SIGTERM', () => bot.stop('SIGTERM'));
