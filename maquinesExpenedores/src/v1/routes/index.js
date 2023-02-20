const express = require("express");
const router = express.Router();

const productsController = require("../../controllers/productes");

router.route("/").get((req, res) => {
  res.send(`<h2>Hello from ${req.baseUrl}</h2>`);
});

router.get("/productes", productsController.getProductes);
router.get("/productes/:id", productsController.getProducte);

module.exports = router;