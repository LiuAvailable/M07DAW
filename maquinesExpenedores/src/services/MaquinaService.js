const Maquina = require("../database/maquines");

const getAllMaquines = () => {
    const allMaquines = Maquina.getAllMaquines();
    return allMaquines;
};

const getMaquina = (idMaquina) => {
    const maquina = Maquina.getMaquina(idMaquina);
    return maquina;
}

module.exports = {
    getAllMaquines,
    getMaquina
}