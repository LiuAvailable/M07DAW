const { SlashCommandBuilder } = require("discord.js");

const mark = new SlashCommandBuilder()
    .setName('mark')
    .setDescription("Retorna la nota d'una tasca d'una classe per privat")
    .addStringOption((option) => option
        .setName('classe')
        .setDescription('De quina classe pertany la tasca')
        .setRequired(true),
        )
    .addStringOption((option) => option
        .setName('tasca')
        .setDescription('Nota de la tasca...')
        .setRequired(true),
        )
    
module.exports = {
    data: mark,
};