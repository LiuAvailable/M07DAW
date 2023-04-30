const {google} = require('googleapis');


/**
 * returns all the tasks in a given course
 */
async function getTasks(auth, courseId) {
    const classroom = google.classroom({ version: 'v1', auth });
  
    const res = await classroom.courses.courseWork.list({
      courseId: courseId,
    });
  
    const courseWork = res.data.courseWork || [];
    return courseWork;
}


function hanPasado5Minutos(fecha) {
  const fechaDada = new Date(fecha);
  const fechaActual = Date.now();
  const minutosTranscurridos = (fechaActual - fechaDada.getTime()) / 1000 / 60;
  return minutosTranscurridos >= 5;
}


async function getMark(auth, curs, tasca){
    const classroom = google.classroom({ version: 'v1', auth });
  
    const res = await classroom.courses.courseWork.studentSubmissions.list({
      courseId: curs,
      courseWorkId: tasca
    })

    let mark = res.data.studentSubmissions[0].assignedGrade;
    if(!mark) mark ='error';
    return mark;
}

/* Returns all users that have a new mark  */
async function getMarkAuto(auth, curs, tasca){
  const classroom = google.classroom({ version: 'v1', auth });

  const res = await classroom.courses.courseWork.studentSubmissions.list({
    courseId: curs,
    courseWorkId: tasca
  })

  let marks = [];
  res.data.studentSubmissions.forEach(m => {
    if(!hanPasado5Minutos(m.updateTime) && m.assignedGrade){
      marks.push({user:m.userId,mark:m.assignedGrade})
    }
  })
  return marks;
}


module.exports = { getTasks, getMark, getMarkAuto }