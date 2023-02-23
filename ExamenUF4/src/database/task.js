const DB = require("./db.json");
const { saveToDatabase } = require("./utils.js");

const createTask = (user, title, description) => {

    let id = DB.TASK.length;
    id = DB.TASK[id-1].id;

    const newTask = {id:parsInt(id) + 1, user:user, title:title, description:description, status:'TODO', createdAt: new Date(), updatedAt: new Date()}
    try{
        DB.TASK.push(newTask);
        saveToDatabase(DB);
        return newTask;
    }catch(e){ return e}
}

const getTask = (id) => {
    return DB.TASK.find(u => u.id === id);
}

const updateTask = (newTask) => {
    const indexForUpdate = DB.TASK.findIndex(
        (task) => task.id === newTask.id
      );
      if (indexForUpdate === -1) {
        return;
      }
      DB.TASK[indexForUpdate] = newTask;
      saveToDatabase(DB);
      return newTask;
}
const deleteTask = (id) => {
    const indexForDeletion = DB.TASK.findIndex(
      (task) => task.id === id
    );
    if (indexForDeletion === -1) {
      return;
    }
    DB.TASK.splice(indexForDeletion, 1);
    saveToDatabase(DB);
}
const getTaskUSer = (id) => {
    return DB.TASK.filter(task => task.user === id);
}
const getUserTaskState = (id, status) => {
    return DB.TASK.filter(task => task.user === id && task.status === status);
}
const getTaskDate = (id, date) => {
    return DB.TASK.filter(task => task.user === id && task.createdAt > date);
}
const getTaskDateStatus = (id, date, status) => {
    return DB.TASK.filter(task => task.user === id && task.createdAt > date && task.status === status);
}

module.exports = {
    createTask,
    getTask,
    updateTask,
    deleteTask,
    getTaskUSer,
    getUserTaskState,
    getTaskDate,
    getTaskDateStatus
};