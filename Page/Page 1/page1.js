var form = document.getElementsByClassName("form-root");

function Form() {
    form[0].classList.toggle("hidden");
}

const data = [100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, 1100, 1200];

const chartDivs = document.querySelectorAll('.chart > .ccol');
const maxHeight = Math.max(...data);

chartDivs.forEach((div, i) => {
    div.style.height = `${(data[i] / maxHeight) * 90}%`;
});

for (let i = 0; i < data.length; i++) {
    const col = document.getElementById(`col${i + 1}`);
    const valueSpan = col.querySelector('.value');
    valueSpan.textContent = data[i];
}