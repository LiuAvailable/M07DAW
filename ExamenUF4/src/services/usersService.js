const userDB = require('../database/users');

const getUsers = (req, res) => {
    return userDB.getUsers();
}
const createUser = (username, fullname) => {
    try {
        const user = userDB.createUser(username, fullname);
        return user;
    } catch (error) {
        return error;
    }
}

module.exports = {
    getUsers,
    createUser
}