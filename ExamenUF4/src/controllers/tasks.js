const taskService = require('../services/taskService');

const createTask = (req, res) => {
    const user = req.body.user;
    const title = req.body.title;
    const description = req.body.description;

    console.log(user)

    if( user && title && description){
        const task = taskService.createTask(user, title, description);
        res.send({status: 'OK', data: task});
    }else res.send({ status: "ERROR", data:"Falten dades"}) 
}

const getTask = (req, res) => {
    if(req.params.id !== undefined){
        const task = taskService.getTask(req.params.id);
        res.send({ status: "OK", data: task });
    }else res.send({ status: "ERROR", data:"Falta l'id"})
}

const modifyTask = (req, res) => {
    const id = req.body.id;
    const user = req.body.user;
    const title = req.body.title;
    const description = req.body.description;
    const status = req.body.status;
    const createdAt = req.body.createdAt;
    const updatedAt = new Date();

    console.log(id)
    console.log(user)
    console.log(title)
    console.log(description)
    console.log(status)
    console.log(createdAt)

    if(id && title && description && status && createdAt && user){
        newTask = {id:id, user:user, title:title, description:description, status:status, createdAt:createdAt, updatedAt:updatedAt}
        taskService.updateTask(newTask)
    }else res.send({status: "ERROR", data:"falten dades"})
}

const deleteTask = (req, res) => {
    if(req.params.id !== undefined){
        const task = taskService.deleteTask(req.params.id);
        res.send({ status: "OK", data: task });
    }else res.send({ status: "ERROR", data:"Falta l'id"})
}

const getTaskUser = (req, res) => {
    if(req.params.id !== undefined){
        const task = taskService.getTaskUSer(req.params.id);
        res.send({ status: "OK", data: task });
    }else res.send({ status: "ERROR", data:"Falta l'id"})
}
const getUserTaskState = (req, res) => {
    if(req.params.id !== undefined && req.params.status !== undefined){
        const task = taskService.getUserTaskState(req.params.id, req.params.status);
        res.send({ status: "OK", data: task });
    }else res.send({ status: "ERROR", data:"Falten dades"})
}
const getTaskDate = (req, res) => {
    if(req.params.id !== undefined && req.params.date !== undefined){
        const task = taskService.getTaskDate(req.params.id, req.params.date);
        res.send({ status: "OK", data: task });
    }else res.send({ status: "ERROR", data:"Falten dades"})
}
const getTaskDateState = (req, res) => {
    if(req.params.id !== undefined && req.params.date !== undefined && req.params.status !== undefined){
        const task = taskService.getTaskDateStatus(req.params.id, req.params.date, req.params.status);
        res.send({ status: "OK", data: task });
    }
}


module.exports = {
    createTask,
    getTask,
    modifyTask,
    deleteTask,
    getTaskUser,
    getUserTaskState,
    getTaskDate,
    getTaskDateState
}