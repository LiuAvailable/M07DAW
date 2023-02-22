const maquinaService = require("../services/maquinaService");

const getMaquines = (req , res) =>{
    const maquines = maquinaService.getAllMaquines();
    res.send({ status: "OK", data: maquines });
}
const getMaquina = (req , res) =>{
    if(req.params.id !== undefined) {
        const maquines = maquinaService.getMaquina(req.params.id);
        res.send({ status: "OK", data: maquines });
    }else res.send({ status: "ERROR", data:"Falta l'id"})
}

module.exports = {
    getMaquines,
    getMaquina
};