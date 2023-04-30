const course = require('./commands/course');
const tasks = require('./commands/tasks');
const register = require('./commands/register');
const mark = require('./commands/mark');

const { getUser, authorize } = require('./api/classroom/index');
const { getTasks, getMark, getMarkAuto } = require('./api/classroom/tasks');
const { getCourse, getAllCourse } = require('./api/classroom/courses');

const DB = require("./database/students.json");
const CONFIG = require("./config.json");

const { saveToDatabase, setConfig } = require("./database/utils.js");


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
        if(course != 'error') {
            try{
                CONFIG.CLASS_ID = course;
                setConfig(CONFIG)
                interaction.editReply("El curs s'ha configurat correctament");
            } catch(e){interaction.editReply("Hi ha hagut un problema al configurar el curs")}
        } else interaction.editReply('el curs no existeix')
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
    if(CONFIG.CLASS_ID){
        authorize()
        .then(auth => getUser(auth, interaction.options.getString('correu'),CONFIG.CLASS_ID))
        .then(user => {
            if(user != undefined){
                const author = interaction.user.id;
                if(!checkIfUserExists(author)){
                    if(!checkIfEmailExists(interaction.options.getString('correu'))){
                        try{
                            DB.STUDENTS.push({discord:author, classroom:interaction.options.getString('correu'), classroomId:user})
                            saveToDatabase(DB);
                            interaction.editReply("T'has registrat correctament!!\nDisfruta les pràctiques màquina.");
                        } catch(e){interaction.editReply("Hi ha hagut un problema al registrar")}
                    } else interaction.editReply('NO ROBIS CORREUS, ja hi ha un usuari registrat amb aquest correu')
                } else interaction.editReply('Se que tens moltes ganes de treballar, pero amb un cop que fassis la pràctica en fas prou. \nJa estas registrat')
            } else interaction.editReply(`Aquest correu no existeix en el classroom, assegure't que estas en el classroom i que has escrit el correu bé`)
        })
    } else { interaction.editReply('El curs no esta configurat correctament, utilitza la comanda /course')}
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

const sendMessage = async (result, userId) => {
    try{
        const user = await client.users.fetch(userId).catch(() => null);
        await user.send(result).catch((e) => {
            console.log(e)
        });
    } catch(e) {console.log(e)}
}

async function main() {
    const commands = [ course.data, tasks.tasks, register.data, mark.data ];

    try {
        console.log('Started refreshing application (/) commands.');
        
        setInterval(async () => {
            authorize()
                .then(auth => getAllCourse(auth))
                .then(courses => {
                    courses.forEach(c => {
                        authorize()
                            .then(auth => getTasks(auth, c.id))
                            .then(tasks => {
                                if(tasks.length > 0){
                                    tasks.forEach(t => {
                                        authorize()
                                        .then(auth => getMarkAuto(auth, c.id, t.id))
                                        .then(users => {
                                            users.forEach(u => {
                                                if(DB.STUDENTS.some(student => student.classroomId === u.user)){
                                                    const student = DB.STUDENTS.find(s => s.classroomId === u.user);
                                                    const msg = `S'ha posat nota a la taska ${t.title} de l'assignatura ${c.name}.\nLa teva puntuació és de ${u.mark}/${t.maxPoints}`
                                                    sendMessage(msg, student.discord)
                                                }
                                            })
                                        })
                                    })
                                }
                            })
                        .catch(console.error);
                    })
                })
        }, 300000)

        await rest.put(Routes.applicationCommands(config.APP_ID), { body: commands });

        client.on('interactionCreate', async interaction => {
            if (!interaction.isCommand()) return;


            const { commandName } = interaction;
            await interaction.deferReply({ ephemeral: true });

            switch (commandName){
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