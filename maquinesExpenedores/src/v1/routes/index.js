const express = require("express");
const router = express.Router();

const productsController = require("../../controllers/productes");
const estocsController = require("../../controllers/estocs");

router.route("/").get((req, res) => {
  res.send(`<h2>Hello from ${req.baseUrl}</h2>`);
});

router.get("/productes", productsController.getProductes);
router.get("/productes/:id", productsController.getProducte);
router.post("/productes", productsController.postProduct);
router.patch("/productes", productsController.modifyProduct);
router.delete("/productes/:id", productsController.deleteProduct);

router.get("/estocs", estocsController.getEstocs);
router.get("/estocs/:id", estocsController.getEstoc);
router.post("/estocs", estocsController.postEstoc);
router.patch("/estocs", estocsController.modifyEstoc);
router.delete("/estocs/:id", estocsController.deleteEstoc);

module.exports = router;