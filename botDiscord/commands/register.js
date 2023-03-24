const { SlashCommandBuilder } = require("discord.js");

const register = new SlashCommandBuilder()
    .setName('register')
    .setDescription("Registre't per poguer rebre les teves notes i taskes pendents des del discord de la classe")
    .addStringOption((option) => option
        .setName('correu')
        .setDescription('Amb quin correu estas a la classe de classroom?')
        .setRequired(true),
        )

module.exports = {
    data: register,
};