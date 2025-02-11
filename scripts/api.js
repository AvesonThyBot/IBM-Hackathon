// Variables
const apiKey = "TXS6SZYV5P87XSY8";
const ctx = $("#myChart").get(0).getContext("2d");
let currentEURPrice = 0; // Stores the current EUR price from the API
let balanceEUR = 100.0; // Starting balance in EUR
let balanceGBP = 0.0; // Starting balance in GBP
const fixedAmount = parseFloat($("#quantity").val());

// --------------------------- Chart Object ---------------------------
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

// --------------------------- Balance Update ---------------------------
function updateBalance() {
	$("#balance-eur").text(`EUR: ${balanceEUR.toFixed(2)}`);
	$("#balance-gbp").text(`GBP: ${balanceGBP.toFixed(2)}`);
	updateTotalValue(); // Update the total value in GBP
}

// --------------------------- Total Value Calculation ---------------------------
function updateTotalValue() {
	const totalValueGBP = balanceGBP + balanceEUR * currentEURPrice; // Convert EUR to GBP and add to GBP balance
	$("#total-value").text(`Total Value: £${totalValueGBP.toFixed(2)}`);
}

// --------------------------- Trade Execution ---------------------------
$(".quantity-left-minus").on("click", () => {
	const fixedAmount = parseFloat($("#quantity").val()); // Get updated value
	if (currentEURPrice === 0 || balanceGBP < fixedAmount) {
		return;
	}
	const eurAmount = fixedAmount / currentEURPrice; // Convert GBP to EUR
	balanceEUR += eurAmount;
	balanceGBP -= fixedAmount;
	updateBalance();
	$("#trade-result").text(`You bought ${eurAmount.toFixed(2)} EUR with ${fixedAmount.toFixed(2)} GBP.`);
});

$(".quantity-right-plus").on("click", () => {
	const fixedAmount = parseFloat($("#quantity").val()); // Get updated value
	if (currentEURPrice === 0 || balanceEUR < fixedAmount) {
		return;
	}
	const gbpAmount = fixedAmount * currentEURPrice; // Convert EUR to GBP
	balanceEUR -= fixedAmount;
	balanceGBP += gbpAmount;
	updateBalance();
	$("#trade-result").text(`You sold ${fixedAmount.toFixed(2)} EUR for ${gbpAmount.toFixed(2)} GBP.`);
});

$("#quantity").on("input", () => {
	const fixedAmount = parseFloat($("#quantity").val());
	$("#trade-result").text(`Current trade amount: £${fixedAmount.toFixed(2)}`);
});

// --------------------------- API Data Fetching ---------------------------
async function fetchForexData() {
	try {
		const response = await $.ajax({
			url: `https://www.alphavantage.co/query?function=FX_MONTHLY&from_symbol=EUR&to_symbol=GBP&apikey=${apiKey}`,
			method: "GET",
		});
		return processForexData(response);
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
				high: parseFloat(values["2. high"]),
			});
		});
		forexData.reverse();
	}
	return forexData;
}

// --------------------------- Chart Animation ---------------------------
function animateChart(forexData) {
	let index = 0;
	const interval = setInterval(() => {
		if (index >= forexData.length) {
			clearInterval(interval);
			return;
		}
		forexChart.data.labels.push(forexData[index].date);
		forexChart.data.datasets[0].data.push(forexData[index].price);
		forexChart.update();
		$("#gbr-span").text("GBR: " + forexData[index].price.toFixed(2));
		$("#eur-span").text("EUR: " + (1 / forexData[index].price).toFixed(2));
		currentEURPrice = forexData[index].high; // Update current EUR price
		index++;
	}, 1000);
}

// --------------------------- Fetch Data on Click ---------------------------
$("#fetch-data").on("click", async () => {
	const forexData = await fetchForexData();
	if (forexData.length > 0) {
		animateChart(forexData);
	}
});

// Initialize balance display
updateBalance();
