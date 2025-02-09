// Variables
const apiKey = "TXS6SZYV5P87XSY8";
const ctx = document.querySelector("#myChart").getContext("2d");

// Chart object
const forexChart = new Chart(ctx, {
	type: "line",
	data: {
		labels: [],
		datasets: [
			{
				label: "EUR to GBP",
				data: [],
				borderColor: "green",
				borderWidth: 1,
				pointRadius: 0,
			},
		],
	},
	options: {
		animation: true,
		responsive: true,
		scales: {
			x: {
				type: "category",
			},
			y: {
				beginAtZero: false,
			},
		},
		plugins: {
			legend: {
				onClick: null,
			},
			decimation: {
				enabled: true,
				algorithm: "lttb",
			},
		},
	},
});

// --------------------------- API Data ---------------------------
async function fetchForexData() {
	try {
		const response = await fetch(`https://www.alphavantage.co/query?function=FX_MONTHLY&from_symbol=EUR&to_symbol=GBP&apikey=${apiKey}`);
		let data = await response.json();
		console.log(data);

		// Process API data
		return processForexData(data);
	} catch (error) {
		console.error("Error fetching data:", error);
		return [];
	}
}

function processForexData(data) {
	let forexData = [];

	if (data["Time Series FX (Monthly)"]) {
		Object.entries(data["Time Series FX (Monthly)"]).forEach(([date, values]) => {
			forexData.push({
				date,
				price: parseFloat(values["4. close"]),
			});
		});

		// Reverse order
		forexData.reverse();
	}

	return forexData;
}

// --------------------------- Chart Animation ---------------------------
function animateChart(forexData) {
	let index = 0;
	const interval = setInterval(() => {
		if (index >= forexData.length) {
			clearInterval(interval); // Stop animation when all points are added
			return;
		}

		// Add data to chart
		forexChart.data.labels.push(forexData[index].date);
		forexChart.data.datasets[0].data.push(forexData[index].price);
		forexChart.update();

		// Update the GBP and EUR spans
		document.querySelector("#gbr-span").textContent = "GBR: " + forexData[index].price.toFixed(2);
		document.querySelector("#eur-span").textContent = "EUR: " + (1 / forexData[index].price).toFixed(2); // Assuming EUR = 1 / GBP

		index++;
	}, 1000); // Speed
}

// On click
document.querySelector("#fetch-data").onclick = async () => {
	const forexData = await fetchForexData();
	if (forexData.length > 0) {
		animateChart(forexData);
	}
};
