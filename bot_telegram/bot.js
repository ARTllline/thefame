// Бот для регистрации на подписку уведомлений заявок сайта TheFame
// Импорт зависимостей и конфигурация окружения
const { Telegraf } = require('telegraf');
const axios = require('axios');
const dotenv = require('dotenv');

dotenv.config();

// Создаем экземпляр бота
const bot = new Telegraf(process.env.BOT_TOKEN);

// Создаем axios-инстанс для работы с Laravel API
// Предполагается, что на стороне Laravel имеется endpoint, принимающий POST-запросы для регистрации пользователей
const api = axios.create({
    baseURL: process.env.LARAVEL_API_URL,
    headers: { Authorization: `Bearer ${process.env.API_TOKEN}` },
});

// Функция для отправки данных пользователя на Laravel API
async function sendUserData(userData) {
    try {
        // Предположим, что endpoint для сохранения данных – /api/users
        const response = await api.post('/api/store-user', userData);
        return response.data;
    } catch (error) {
        console.error('Ошибка при отправке данных в API:', error);
        throw error;
    }
}

// Команда /start: собираем данные пользователя и отправляем их в API
bot.start(async (ctx) => {
    // Собираем основные данные пользователя из объекта ctx.from
    const userData = {
        telegram_id: ctx.from.id,
        first_name: ctx.from.first_name,
        last_name: ctx.from.last_name || null,
        username: ctx.from.username || null,
        // Дополнительные поля можно добавить, если необходимо
    };

    try {
        const apiResponse = await sendUserData(userData);
        await ctx.reply('Вы успешно зарегистрированы на подписку уведомлений заявок сайта TheFame.');
        console.log('Ответ API:', apiResponse);
    } catch (error) {
        await ctx.reply('Извините, произошла ошибка при регистрации. Попробуйте еще раз позже.');
    }
});

// Дополнительная команда /help для отображения справки
bot.command('help', (ctx) => {
    ctx.reply('Этот бот предназначен для регистрации на подписку уведомлений заявок сайта TheFame. Используйте команду /start для регистрации.');
});

// Обработка любых текстовых сообщений – подсказка зарегистрироваться
bot.on('text', async (ctx) => {
    await ctx.reply('Для регистрации на подписку уведомлений заявок используйте команду /start');
});

// Запускаем бота
bot.launch().then(() => {
    console.log('Бот успешно запущен');
});

// Graceful shutdown: обрабатываем завершение работы бота
process.once('SIGINT', () => bot.stop('SIGINT'));
process.once('SIGTERM', () => bot.stop('SIGTERM'));
