const taskDB = require('../database/task');

const createTask = (user, title, description) => {
    try {
        const task = taskDB.createTask(user, title, description);
        return task;
    } catch (error) {
        return error;
    }
}

const getTask = (id) => {
    return taskDB.getTask(id)
}
const updateTask = (newTask) => {
    return taskDB.updateTask(newTask)
}
const deleteTask = (id) => {
    return taskDB.deleteTask(id)
};
const getTaskUSer = (id) => {
    return taskDB.getTaskUSer(id);
}
const getUserTaskState = (id,status) => {
    return taskDB.getUserTaskState(id, status);
}
const getTaskDate =(id,date) => {
    return taskDB.getTaskDate(id, date);
}
const getTaskDateStatus = (id, date, status) => {
    return taskDB.getTaskDateStatus(id, date, status);
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