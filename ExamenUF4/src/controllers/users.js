const userService = require('../services/usersService');

const getUsers = (req, res) => {
    const user = userService.getUsers();
    res.send({ status: "OK", data: user });
}

const createUser = (req, res) => {
    const username = req.body.username;
    const fullname = req.body.fullname;

    if( fullname && username){
        const user = userService.createUser(username, fullname);
        res.send({status: 'OK', data: user});
    }else res.send({ status: "ERROR", data:"Falten dades"}) 
}
module.exports = {
    getUsers,
    createUser
}