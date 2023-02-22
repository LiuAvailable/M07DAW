const express = require("express");
const router = express.Router();

const productsController = require("../../controllers/productes");

router.route("/").get((req, res) => {
  res.send(`<h2>Hello from ${req.baseUrl}</h2>`);
});

router.get("/productes", productsController.getProductes);
router.get("/productes/:id", productsController.getProducte);
router.post("/productes", productsController.postProduct);
router.patch("/productes", productsController.modifyProduct);
router.delete("/productes/:id", productsController.deleteProduct);

module.exports = router;