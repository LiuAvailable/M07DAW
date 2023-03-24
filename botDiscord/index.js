const ping = require('./commands/ping');
const course = require('./commands/course');
const tasks = require('./commands/tasks');
const register = require('./commands/register');
const mark = require('./commands/mark');

const { getUser, authorize } = require('./api/classroom/index');
const { getTasks, getMark } = require('./api/classroom/tasks');
const { getCourse } = require('./api/classroom/courses');

const DB = require("./database/students.json");
const { saveToDatabase } = require("./database/utils.js");


const {REST} = require('@discordjs/rest');


const { Client, GatewayIntentBits, Routes } = require('discord.js');
const config = require("./config.json");

const client = new Client({
    intents: [
        GatewayIntentBits.DirectMessages,
        GatewayIntentBits.Guilds,
        GatewayIntentBits.GuildMessages,
        GatewayIntentBits.MessageContent
    ]
})

const rest = new REST({ version: '10' }).setToken(config.BOT_TOKEN);

/**
 * retorna l'id d'un curs
 */
const getCourseCommand = (interaction) => {
    authorize()
    .then(auth => getCourse(auth, interaction.options.getString('nom')))
    .then(course => {
        if(course != 'error') interaction.editReply(course);
        else interaction.editReply('el curs no existeix')
    })
    .catch(console.error);
} 

/**
 * retorna totes les comandes sense filtres
 */
const getAllTasksCommand = (interaction) => {
    authorize()
    .then(auth => getCourse(auth, interaction.options.getString('curs')))
    .then(course => {
        if(course != 'error'){
            authorize()
            .then(auth => getTasks(auth, course))
            .then(tasks => {
                console.log(tasks[1])
                if(tasks.length > 0){
                    let taskTitles = '';
                    tasks.map(task => taskTitles = `${taskTitles}\n${task.title}`);
                    interaction.editReply(taskTitles);
                } else interaction.editReply(`la classe ${interaction.options.getString('curs')} no te cap tasca`)
            })
        }else interaction.editReply('el curs no existeix')
    })
    .catch(console.error);
}

/**
 * regsitrar un usuari
 */
const saveUserCommand = (interaction) => {
    authorize()
    .then(auth => getUser(auth, interaction.options.getString('correu')))
    .then(user => {
        if(user != undefined){
            const author = interaction.user.id;
            if(!checkIfUserExists(author)){
                if(!checkIfEmailExists(interaction.options.getString('correu'))){
                    DB.STUDENTS.push({discord:author, classroom:interaction.options.getString('correu')})
                    saveToDatabase(DB);
                    interaction.editReply("T'has registrat correctament!!\nDisfruta les pràctiques màquina.");
                } else interaction.editReply('NO ROBIS CORREUS, ja hi ha un usuari registrat amb aquest correu')
            } else interaction.editReply('Se que tens moltes ganes de treballar, pero amb un cop que fassis la pràctica en fas prou. \nJa estas registrat')
        } else interaction.editReply(`Aquest correu no existeix en el classroom, assegure't que estas en el classroom i que has escrit el correu bé`)

    }) 
}

// valida si un usuari existeix
const checkIfUserExists = (user) => {
    return  DB.STUDENTS.find(st => st.discord == user)
}
// valida si un correu existeix
const checkIfEmailExists = (mail) => {
    return DB.STUDENTS.find(st => st.classroom == mail)
}

/**
 * Funcio per agafar la nota d'una tasca
 */
const getMarkCommand = (interaction) => {


    if(checkIfUserExists(interaction.user.id)){
        const classroomUser = DB.STUDENTS.find(st => st.discord == interaction.user.id).classroom
        if(classroomUser != null && classroomUser != undefined){
            const classe = interaction.options.getString('classe');
            const tasca = interaction.options.getString('tasca');
            let courseId;
            let task;
            authorize()
            .then(auth => getCourse(auth, classe))
            .then(course => {
                if(course != 'error') {
                    courseId = course;
                    authorize()
                        .then(auth => getTasks(auth, course))
                        .then(tasks => {
                            if(tasks.length > 0){
                                let taskId = tasks.find(t => t.title.toLocaleLowerCase() == tasca.toLocaleLowerCase());
                                if(taskId){
                                    task = taskId;

                                    authorize()
                                    .then(auth => getMark(auth, courseId, task.id))
                                    .then( mark => {
                                        if(mark != 'error'){
                                            interaction.user.send(`La teva nota de la pràctica ${task.title} és: ${mark}/${task.maxPoints}`)
                                            interaction.editReply("T'ho he xivat per privat 😜")
                                        } else interaction.editReply("Encara no s'ha posat nota")
                                    })
                                }else interaction.editReply('La tasca especificada no existeix');
                            } else interaction.editReply(`La classe ${classe} no te cap tasca`);
                        })
                    .catch(console.error);
                } else interaction.editReply('el curs no existeix')
            })
            .catch(console.error);
        }else interaction.editReply('Hi ha hagut un problema amb el teu usuari')
    } else interaction.editReply('No estas registrat!!')
}


async function main() {
    const commands = [ ping.data, course.data, tasks.tasks, register.data, mark.data ];

    try {
        console.log('Started refreshing application (/) commands.');
        await rest.put(Routes.applicationCommands(config.APP_ID), { body: commands });

        client.on('interactionCreate', async interaction => {
            if (!interaction.isCommand()) return;


            const { commandName } = interaction;
            await interaction.deferReply({ ephemeral: true });

            switch (commandName){
                case 'ping':
                    await ping.execute(interaction);
                    break;
                case 'course':
                    getCourseCommand(interaction);
                    break;
                case 'tasks':
                    getAllTasksCommand(interaction);
                    break;
                case 'register':
                    saveUserCommand(interaction)
                    break;
                case 'mark':
                    getMarkCommand(interaction)
                    break;
                case 'taskspendent':
                    getTasksPendentCommand(interaction)
                    break;

            }

        });

        client.login(config.BOT_TOKEN);

    } catch (err) {
      console.log(err);
    }
  }
  
  authorize();
  main();