const { SlashCommandBuilder } = require("discord.js");

const tasks = new SlashCommandBuilder()
    .setName('tasks')
    .setDescription("Retorna les tasques d'una classe")
    .addStringOption((option) => option
        .setName('curs')
        .setDescription('Les classes de quin curs?')
        .setRequired(true),
        )

module.exports = {
    tasks: tasks,
};