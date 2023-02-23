const express = require("express");
const router = express.Router();

const taskController = require("../../controllers/tasks");
const userController = require("../../controllers/users");

router.get("/users", userController.getUsers)
router.post("/users", userController.createUser)


router.get("/task/:id", taskController.getTask)
router.get("/task/user/:id", taskController.getTaskUser)
router.get("/task/user/:id/status/:status", taskController.getUserTaskState)
router.get("/task/user/:id/date/:date", taskController.getTaskDate)
router.get("/task/user/:id/status/:status/date/:date", taskController.getTaskDateState)
router.post("/task", taskController.createTask)
router.patch("/task", taskController.modifyTask)
router.delete("/task/:id", taskController.deleteTask)

module.exports = router;