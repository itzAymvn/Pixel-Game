// Checking if the user is logged in or not
const isLogged = player.role === "Player" ? true : false;

// Preparing the board

const board = document.querySelector("#board");
const boardWidth = board.offsetWidth;
const boardHeight = board.offsetHeight;

const bloxWidth = Math.floor(boardWidth / 10);
const bloxHeight = Math.floor(boardHeight / 10);
const boxArea = bloxWidth * bloxHeight;

for (let i = 0; i < boxArea; i++) {
    const box = document.createElement("div");
    box.classList.add("box");
    box.style.backgroundColor = "white";
    board.appendChild(box);
}

// Preparing the colors area

const colors = document.querySelector("#colors");
const colorsArray = [
    "red",
    "green",
    "blue",
    "yellow",
    "orange",
    "purple",
    "black",
    "white",
];

isLogged &&
    colorsArray.forEach((color) => {
        const colorDiv = document.createElement("div");
        colorDiv.classList.add("color");
        colorDiv.dataset.color = color;
        colorDiv.style.backgroundColor = color;
        colors.appendChild(colorDiv);
    });

// Game logic

const boxes = document.querySelectorAll(".box");
const colorsDivs = document.querySelectorAll(".color");
const timer = document.querySelector("#timer");

let currentColor = "black";
let delayInSec = 30;
let lastPlaced = Number(player.lastPlacedPixel);

let timerRunning = false;

isLogged &&
    colorsDivs.forEach((color) => {
        color.addEventListener("click", (e) => {
            currentColor = color.dataset.color;
            color.style.transform = "scale(1.5)";
            colorsDivs.forEach((color) => {
                if (color.dataset.color !== currentColor) {
                    color.style.transform = "scale(1)";
                }
            });
        });
    });

// get the placed pixels from the database and update the board

const getPlacedPixels = () => {
    boxes.forEach((box) => {
        box.style.backgroundColor = "white";
        box.dataset.color = "white";
        box.dataset.placed = 0;
    });
    fetch("./actions/RetrievePixels.php")
        .then((response) => response.json())
        .then((responseJson) => {
            responseJson.forEach((pixel) => {
                boxes[pixel.pixelIndex].style.backgroundColor = pixel.color;
                boxes[pixel.pixelIndex].dataset.color = pixel.color;
                boxes[pixel.pixelIndex].dataset.placed = pixel.placed_at;
            });
        })
        .catch((err) => {
            console.log(err);
        });
};

getPlacedPixels();
setInterval(getPlacedPixels, 1000);

// End of the placed pixels logic

// The logic for placing pixels with a limit of 1 pixel every 30 seconds

const updateTimer = () => {
    const now = Date.now();
    const timePassed = Math.floor((now - lastPlaced) / 1000);
    const timeLeft = delayInSec - timePassed;
    if (timeLeft > 0) {
        timer.innerHTML = timeLeft;
    } else {
        timer.innerHTML = delayInSec;
    }
};
isLogged &&
    setInterval(() => {
        if (isLogged) {
            updateTimer();
        }
    }, 1000);

isLogged && updateTimer();

boxes.forEach((box, i) => {
    if (isLogged) {
        box.addEventListener("click", (e) => {
            const now = Date.now();
            if (now - lastPlaced >= delayInSec * 1000) {
                box.style.backgroundColor = currentColor;
                box.dataset.color = currentColor;
                box.dataset.placed = now;
                lastPlaced = now;

                // insert the placed pixel into the database along with the current color and the user id
                const pixel = {
                    player_id: player.id,
                    color: currentColor,
                    pixelIndex: i,
                    placed_at: now,
                };

                fetch("./actions/insertPixel.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(pixel),
                })
                    .then((response) => response.text())
                    .then((responseText) => {
                        console.info(responseText); // result: "Pixel placed successfully" or "Invalid request"
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            }
        });
    } else {
        box.addEventListener("click", (e) => {
            alert("You must be logged in to play!");
        });
    }
});
