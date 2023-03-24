
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

const {google} = require('googleapis');

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

module.exports = { getTasks, getMark }