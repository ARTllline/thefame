// index.js
const { Telegraf, Markup } = require('telegraf');
const axios = require('axios');
require('dotenv').config();

const bot = new Telegraf(process.env.BOT_TOKEN);
const api = axios.create({
    baseURL: process.env.LARAVEL_API_URL,
    headers: { Authorization: `Bearer ${process.env.API_TOKEN}` },
});

// Варианты регионов
const REGION_LABELS = {
    dubai: 'Dubai',
    ua:    'UA',
};

// Собираем основное меню с кнопкой «Настройка региона»
function mainKeyboard() {
    return Markup.keyboard([
        ['Настройка региона']
    ]).resize();
}

// Формируем inline‑кнопки с текущими статусами
function regionInlineKeyboard(statuses) {
    return Markup.inlineKeyboard([
        [ Markup.button.callback(
            `${REGION_LABELS.dubai} ${statuses.dubai ? '✅' : '❌'}`,
            'toggle_dubai'
        )
        ],
        [ Markup.button.callback(
            `${REGION_LABELS.ua} ${statuses.ua ? '✅' : '❌'}`,
            'toggle_ua'
        )
        ],
    ]);
}

// Старт и регистрация
bot.start(async (ctx) => {
    const userData = {
        telegram_id: ctx.from.id,
        first_name:  ctx.from.first_name,
        last_name:   ctx.from.last_name || null,
        username:    ctx.from.username || null,
    };

    try {
        await api.post('/api/store-user', userData); // ваш существующий метод
        await ctx.reply(
            'Вы успешно зарегистрированы на подписку уведомлений.',
            mainKeyboard()
        );
    } catch (e) {
        console.error(e);
        await ctx.reply('Ошибка при регистрации, попробуйте позже.', mainKeyboard());
    }
});

// Обработчик текста «Настройка региона»
bot.hears('Настройка региона', async (ctx) => {
    try {
        const res = await api.get('/api/user/regions', {
            params: { telegram_id: ctx.from.id }
        });
        const { statuses } = res.data;
        await ctx.reply(
            'Текущий статус уведомлений:',
            regionInlineKeyboard(statuses)
        );
    } catch (e) {
        console.error(e);
        await ctx.reply('Не удалось получить настройки региона. Попробуйте позже.');
    }
});

// Обработка нажатия на чекбокс
bot.action(/toggle_(dubai|ua)/, async (ctx) => {
    const region = ctx.match[1];
    await ctx.answerCbQuery(); // чтобы убрать «часики»
    try {
        const res = await api.post('/api/user/change-region', {
            telegram_id: ctx.from.id,
            region,
        });
        const { message, statuses } = res.data;
        // правим текст кнопок сразу
        await ctx.editMessageReplyMarkup(regionInlineKeyboard(statuses).reply_markup);
        await ctx.reply(message);
    } catch (e) {
        console.error(e);
        await ctx.reply('Не удалось переключить уведомления. Попробуйте позже.');
    }
});

// Любой текст — подсказка
bot.on('text', (ctx) => {
    ctx.reply('Для настройки региона нажмите кнопку «Настройка региона»', mainKeyboard());
});

bot.launch()
    .then(() => console.log('Бот запущен'))
    .catch(console.error);

// graceful stop
process.once('SIGINT', () => bot.stop('SIGINT'));
process.once('SIGTERM', () => bot.stop('SIGTERM'));
