
//Creates "result" that displays a hash
function addResult(i, location, name, hash, file, author, created, upvotes, downvotes) { //addResult(3, "featured", "Batman.mp4", "h35g2uy5t23v5v3t2yu52", 10, 1)
  let resultLocation = document.getElementById(location); //Location

  //Main div
  let resultDiv = document.createElement("div");
  resultDiv.classList.add("result");
  resultDiv.id = "result" + location + i;
  resultLocation.appendChild(resultDiv);

  //File picture
  let fileImg = document.createElement("img");
  fileImg.classList.add("file-image");
  fileImg.id = "file-image" + location + i;
  fileImg.src = "https://p7.hiclipart.com/preview/819/333/198/video-camera-ico-icon-camera.jpg";
  resultDiv.appendChild(fileImg);

  //Info Div
  let hashInfoDiv = document.createElement("div");
  hashInfoDiv.classList.add("hash-info");
  hashInfoDiv.id = "hash-info" + location + i;
  resultDiv.appendChild(hashInfoDiv);

  //Name Div
  let titleDiv = document.createElement("div");
  titleDiv.classList.add("title");
  titleDiv.id = "name" + location + i;
  titleDiv.innerHTML = name; //Retrive from DB
  hashInfoDiv.appendChild(titleDiv);

  //Hash Div
  let hashDiv = document.createElement("a");
  hashDiv.classList.add("hash");
  hashDiv.id = "hash" + location + i;
  hashDiv.target = "_blank";
  hashDiv.rel = "noopener noreferrer";
  hashDiv.href = "http://127.0.0.1:8080/ipfs/" + hash + "/" + file;
  hashDiv.setAttribute('onclick', `linkViewModal("${name}", "${hash}", "${file}", "${upvotes}", "${downvotes}")`);
  hashDiv.innerHTML = hash; //Retrive from DB
  hashInfoDiv.appendChild(hashDiv);

  //authorDiv
  let authorDiv = document.createElement("div");
  authorDiv.classList.add("author");
  authorDiv.id = "author" + location + i;
  authorDiv.innerHTML = author;
  hashInfoDiv.appendChild(authorDiv);

  //timeDiv
  let timeDiv = document.createElement("div");
  timeDiv.classList.add("time");
  timeDiv.id = "time" + location + i;
  timeDiv.innerHTML = palateTimeDifference(calculateTimeDifference(created));
  hashInfoDiv.appendChild(timeDiv);

  //Score Div
  let scoreDiv = document.createElement("div");
  scoreDiv.classList.add("score");
  scoreDiv.id = "score" + location + i;
  resultDiv.appendChild(scoreDiv);

  let upvotesText = document.createElement("div");
  upvotesText.classList.add("upvotes");
  upvotesText.id = "upvotes" + location + i;
  upvotesText.innerHTML = upvotes;
  scoreDiv.appendChild(upvotesText);

  let slashCharacter = document.createElement("div");
  slashCharacter.classList.add("slash");
  slashCharacter.innerHTML = "/";
  scoreDiv.appendChild(slashCharacter);

  let downvotesText = document.createElement("div");
  downvotesText.classList.add("downvotes");
  downvotesText.id = "downvotes" + location + i;
  downvotesText.innerHTML = downvotes;
  scoreDiv.appendChild(downvotesText);
}

function linkViewModal(name, hash, file, upvotes, downvotes) {

  // Get the modal
  let modal = document.getElementById("hashModal");

  modal.style.display = "block";

  let modalContent = document.getElementById("hashModalContent");

  //Name Div
  let nameDiv = document.createElement("div");
  nameDiv.classList.add("name");
  nameDiv.id = "name";
  nameDiv.innerHTML = name; //Retrive from DB
  modalContent.appendChild(nameDiv);

  //Hash Div
  let hashDiv = document.createElement("a");
  hashDiv.classList.add("hash");
  hashDiv.id = "hash";
  hashDiv.innerHTML = hash; //Retrive from DB
  modalContent.appendChild(hashDiv);

  //Score Div
  let scoreDiv = document.createElement("div");
  scoreDiv.classList.add("score");
  scoreDiv.id = "score";
  modalContent.appendChild(scoreDiv);

  let upvotesText = document.createElement("p");
  upvotesText.classList.add("upvotemodal");
  upvotesText.innerHTML = upvotes;
  scoreDiv.appendChild(upvotesText);

  let slashCharacter = document.createElement("p");
  slashCharacter.classList.add("slashmodal");
  slashCharacter.innerHTML = "/";
  scoreDiv.appendChild(slashCharacter);

  let downvotesText = document.createElement("p");
  downvotesText.classList.add("downvotemodal");
  downvotesText.innerHTML = downvotes;
  scoreDiv.appendChild(downvotesText);

  let link_hash = document.createElement("input"); //Link identfier
  link_hash.classList.add("link_hash");
  link_hash.type = "hidden";
  link_hash.name = "link_hash";
  link_hash.value = hash;
  let hashModalForm = document.getElementById('hashModalForm');
  hashModalForm.appendChild(link_hash);

  // Get the <span> element that closes the modal
  let span = document.getElementsByClassName("close")[0];

  let content = [nameDiv, hashDiv, scoreDiv];
  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
    removeContent(content);
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
      removeContent(content);
    }
  }
}

function removeContent(content) {
  for (var i = 0; i < content.length; i++) {
    content[i].remove();
  }
}

//Gets difference between now and link date in seconds
function calculateTimeDifference(created) {
  let createdSplit = created.split('-').join(',').split(' ').join(',').split(':').join(',').split(',');
  let linkYear;
  let linkMonth;
  let linkDate;
  let linkHours;
  let linkMinutes;
  let linkSeconds;
  for (var i = 0; i < createdSplit.length; i++) {
    switch (i) {
      case 0:
        linkYear = createdSplit[i];
        break;
      case 1:
        linkMonth = createdSplit[i];
        break;
      case 2:
        linkDate = createdSplit[i];
        break;
      case 3:
        linkHours = createdSplit[i];
        break;
      case 4:
        linkMinutes = createdSplit[i];
        break;
      case 5:
        linkSeconds = createdSplit[i];
        break;
    }
  }
  let date = new Date();
  let year = date.getUTCFullYear();
  let month = date.getUTCMonth() + 1;
  let dateofmonth = date.getUTCDate();
  let hours = date.getUTCHours();
  let minutes = date.getUTCMinutes();
  let seconds = date.getUTCSeconds();
  let difference = Date.UTC(year, month, dateofmonth, hours, minutes, seconds) - Date.UTC(linkYear, linkMonth, linkDate, linkHours, linkMinutes, linkSeconds);
  return difference;
}

//Converts miliseconds into a paletable format
function palateTimeDifference(difference) {
    if (difference < 31556952000) { //Year
      if (difference < 2592000000) { //Month
        if (difference < 86400000) { //Day
          if (difference < 3600000) { //Hour
            if (difference < 60000) { //Minutes
              if (difference < 1000) { //Seconds
                return "1 second ago";
              }
              let time = parseInt(difference / 1000);
              if (time == 1) {
                return time + " second ago";
              }
              return time + " seconds ago";
            }
            let time = parseInt(difference / 60000);
            if (time == 1) {
              return time + " minute ago";
            }
            return time + " minutes ago";
          }
          let time = parseInt(difference / 3600000);
          if (time == 1) {
            return time + " hour ago";
          }
          return time + " hours ago";
        }
        let time = parseInt(difference / 86400000);
        if (time == 1) {
          return time + " day ago";
        }
        return time + " days ago";
      }
      let time = parseInt(difference / 2592000000);
      if (time == 1) {
        return time + " month ago";
      }
      return time + " months ago";
    }
    let time = parseInt(difference / 31556952000);
    if (time == 1) {
      return time + " year ago";
    }
    return time + " years ago";
}
