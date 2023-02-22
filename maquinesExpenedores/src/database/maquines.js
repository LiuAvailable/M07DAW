const DB = require("./db.json");

const getAllMaquines = () => {
    return DB.Maquina;
};
const getMaquina = (idMaquina) => {
    return DB.Maquina.find(p => p.id === idMaquina);
}
module.exports = { 
    getAllMaquines,
    getMaquina
};