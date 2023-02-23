const DB = require('./db.json');
const { saveToDatabase } = require("./utils.js");

const getUsers = () => {
    return DB.USUARI;
}
const createUser = (username, fullname) => {

    let id = DB.USUARI.length;
    id = DB.USUARI[id-1].id;

    const createdAt = new Date()
    const updatedAt = new Date();

    const newUser = {id:parseInt(id)+1, username:username, fullname:fullname, createdAt:createdAt, updatedAt:updatedAt}
    console.log(newUser)
    try{
        DB.USUARI.push(newUser);
        saveToDatabase(DB);
        return newUser;
    }catch(e){ return e}
}

module.exports = {
    getUsers,
    createUser
};