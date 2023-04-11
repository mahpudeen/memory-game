const moves = document.getElementById("moves-count");
const timeValue = document.getElementById("time");
const point = document.getElementById("point");
const startButton = document.getElementById("start");
const submitButton = document.getElementById("submit");
const mainData = document.getElementById("user-data");
const gameContainer = document.querySelector(".game-container");
const result = document.getElementById("result");
const controls = document.querySelector(".controls-container");
let cards;
let interval;
let interval2;
let firstCard = false;
let secondCard = false;

const backgrounds = ["yellow.png", "red.png", "green.png"];
const eyes = ["closed.png", "laughing.png", "long.png", "normal.png", "rolling.png", "winking.png"];
const smiles = ["sad.png", "smiling.png", "straight.png", "surprise.png", "teeth.png", "open.png"];

let items = [];
setRandomItems();
function setRandomItems() {
  items = []
  for(let i = 0; i < 5; i++) {
    let newItem = {};
    newItem.name = "image" + (i+1);

    // set the smile randomly and unique from the available options
    let uniqueSmile = getRandomUnique(smiles, items.map(item => item.smile));
    newItem.smile = "img/" + uniqueSmile;

    // set the eye randomly and unique from the available options
    let uniqueEye = getRandomUnique(eyes, items.map(item => item.eye));
    newItem.eye = "img/" + uniqueEye;

    // set the background randomly from the available options
    newItem.background = "img/" + backgrounds[Math.floor(Math.random() * backgrounds.length)];

    items.push(newItem);
  }
}

function getRandomUnique(options, usedOptions) {
  let availableOptions = options.filter(option => !usedOptions.includes("img/" + option));
  let randomIndex = Math.floor(Math.random() * availableOptions.length);
  return availableOptions[randomIndex];
}

//Initial Time
let seconds = 0,
  minutes = 0;

//Initial moves and win count
let movesCount = 0,
  winCount = 0;
let points = 0

//Initial Date
let startTime = Date.now();

//For timer
const timeGenerator = () => {
  seconds += 1;
  //minutes logic
  if (seconds >= 60) {
    minutes += 1;
    seconds = 0;
  }
  //format time before displaying
  let secondsValue = seconds < 10 ? `0${seconds}` : seconds;
  let minutesValue = minutes < 10 ? `0${minutes}` : minutes;
  timeValue.innerHTML = `<span>Time:</span>${minutesValue}:${secondsValue}`;
};

//For calculating moves
const movesCounter = () => {
  movesCount += 1;
  moves.innerHTML = `<span>Moves:</span>${movesCount}`;
};

//Pick random objects from the items array
const generateRandom = (size = 5) => {
  //temporary array
  let tempArray = [...items];
  //initializes cardValues array
  let cardValues = [];
  //size should be double (4*4 matrix)/2 since pairs of objects would exist
  size = (size * 2) / 2;
  //Random object selection
  for (let i = 0; i < size; i++) {
    const randomIndex = Math.floor(Math.random() * tempArray.length);
    cardValues.push(tempArray[randomIndex]);
    //once selected remove the object from temp array
    tempArray.splice(randomIndex, 1);
  }
  return cardValues;
};

const matrixGenerator = (cardValues, size = 5) => {
  gameContainer.innerHTML = "";
  cardValues = [...cardValues, ...cardValues];
  //simple shuffle
  cardValues.sort(() => Math.random() - 0.5);
  for (let i = 0; i < size * 2; i++) {
    /*
        Create Cards
        before => front side (contains question mark)
        after => back side (contains actual image);
        data-card-values is a custom attribute which stores the names of the cards to match later
      */
    gameContainer.innerHTML += `
     <div class="card-container" data-card-value="${cardValues[i].name}">
        <div class="card-before">?</div>
        <div class="card-after">
          <div class="image-stack">
            <img src="${cardValues[i].background}" alt="image 1">
            <img src="${cardValues[i].eye}" alt="image 2">
            <img src="${cardValues[i].smile}" alt="image 3">
          </div>
        </div>
     </div>
     `;
  }

  //Cards
  cards = document.querySelectorAll(".card-container");
  cards.forEach((card) => {
    card.addEventListener("click", () => {
      //If selected card is not matched yet then only run (i.e already matched card when clicked would be ignored)
      if (!card.classList.contains("matched")) {
        //flip the cliked card
        card.classList.add("flipped");
        //if it is the firstcard (!firstCard since firstCard is initially false)
        if (!firstCard) {
          //so current card will become firstCard
          firstCard = card;
          //current cards value becomes firstCardValue
          firstCardValue = card.getAttribute("data-card-value");
        } else {
          //increment moves since user selected second card
          movesCounter();
          //secondCard and value
          secondCard = card;
          let secondCardValue = card.getAttribute("data-card-value");
          if (firstCardValue == secondCardValue) {
            //if both cards match add matched class so these cards would beignored next time
            firstCard.classList.add("matched");
            secondCard.classList.add("matched");
            //set firstCard to false since next card would be first now
            firstCard = false;
            //winCount increment as user found a correct match
            winCount += 1;
            //check if winCount ==half of cardValues
            if (winCount == Math.floor(cardValues.length / 2)) {
              stopGame();
            }
          } else {
            //if the cards dont match
            //flip the cards back to normal
            let [tempFirst, tempSecond] = [firstCard, secondCard];
            firstCard = false;
            secondCard = false;
            let delay = setTimeout(() => {
              tempFirst.classList.remove("flipped");
              tempSecond.classList.remove("flipped");
            }, 900);
          }
        }
      }
    });
  });
};
function updateDisplay() {
  var currentTime = Date.now();
  var timeElapsed = (currentTime - startTime) / 1000; // Convert to seconds
  let attempts = movesCount
  if (attempts == 0) {
    attempts = 1
  }
  points = Math.round(10000 / (attempts * timeElapsed)); // Calculate points based on attempts and time
  point.innerHTML = `<span>Points:</span> ${points}`;
}
function stopGame() {
  result.innerHTML = `
  <div class="result-box">
    <h2>You Won!!!</h2>
    <h4>Moves: ${movesCount}</h4>
    <h4>Points: ${points}</h4>
  </div>
  `;
  setRandomItems();
  var isLoggedIn = mainData.getAttribute("data-value");
  if (isLoggedIn == 1) {
    submitButton.classList.remove("hide");
  } else {
    submitButton.classList.add("hide");
  }
  controls.classList.remove("hide");
  // stopButton.classList.add("hide");
  startButton.classList.remove("hide");
  startButton.innerText = "Play Again"
  clearInterval(interval);
  clearInterval(interval2);
}
function startGame() {
  movesCount = 0;
  seconds = 0;
  minutes = 0;
  startTime = Date.now();
  //controls amd buttons visibility
  controls.classList.add("hide");
  startButton.classList.add("hide");
  //Start timer
  interval = setInterval(timeGenerator, 1000);
  interval2 = setInterval(updateDisplay, 1000);
  //initial moves
  moves.innerHTML = `<span>Moves:</span> ${movesCount}`;
  initializer();
}
//Start game
startButton.addEventListener("click", () => {
  startGame();
});

// Submit score
submitButton.addEventListener("click", () => {
  console.log(points)
  var dataToSend = {
    points: points,
  };

  // Send data ke PHP use XMLHttpRequest
  var xhr = new XMLHttpRequest();
  xhr.open('POST', './pairs.php', true);
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Response from PHP success
      // var response = JSON.parse(xhr.responseText);
      window.location.href = '/leaderboard.php';
    }
  };
  xhr.send(JSON.stringify(dataToSend));
});

//Initialize values and func calls
const initializer = () => {
  result.innerText = "";
  winCount = 0;
  let cardValues = generateRandom();
  console.log(cardValues);
  matrixGenerator(cardValues);
};


startGame();