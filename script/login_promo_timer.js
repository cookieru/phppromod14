const timer = document.querySelector("#login_promo_time");
let timerInterval;
let timerValue;

function timerStart(startTime) {
    timerValue = startTime;
    timerInterval = setInterval(() => {
        timerValue--;

        if (timerValue < 0) {
            location.reload();
            return;
        }

        timer.innerText = String(Math.floor(timerValue / 3600)).padStart(2, "0") + ":" +
            String((Math.floor(timerValue / 60) % 60)).padStart(2, "0") + ":" +
            String((timerValue % 60)).padStart(2, "0");
    }, 1000);
}