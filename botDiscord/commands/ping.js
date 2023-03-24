const { SlashCommandBuilder } = require("discord.js");

const ping = new SlashCommandBuilder()
    .setName('ping')
    .setDescription("No t'aburreixis a classe!!\nA mi tampoc m'agrada escoltar, juguem a Ping Pong")


module.exports = {
    data: ping,
    async execute(interaction) {
        await interaction.reply('Pong!');
    }
};
