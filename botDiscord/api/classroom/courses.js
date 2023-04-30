const {google} = require('googleapis');

/**
 * return course id
 */
async function getCourse(auth, courseName) {
    const classroom = google.classroom({ version: 'v1', auth });
    let course;
    let nextPageToken = null;
  
      do {
        let res = await classroom.courses.list({
          pageSize: 0,
        });
  
        course = res.data.courses.find(c => c.name.toLowerCase() === courseName.toLowerCase());
        if (course) nextPageToken = null;
        else nextPageToken = res.data.nextPageToken;
      } while (nextPageToken);
  
  
    let id;
    if(!course) id = 'error';
    else id = course.id;
  
    return id;
}

/**
 * return course id
 */
async function getAllCourse(auth) {
  const classroom = google.classroom({ version: 'v1', auth });

  let res = await classroom.courses.list({
    pageSize: 0,
  });
  return res.data.courses
}

module.exports = { getCourse, getAllCourse }

