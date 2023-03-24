const { SlashCommandBuilder } = require("discord.js");


const course = new SlashCommandBuilder()
    .setName('course')
    .setDescription("Retorna l'id d'una classe")
    .addStringOption((option) => option
        .setName('nom')
        .setDescription('Quina classe vols agafar?')
        .setRequired(true),
        )

module.exports = {
        data: course
};
