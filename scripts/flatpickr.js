// Variables
const maxDate = new Date(
  new Date().getFullYear(),
  new Date().getMonth() + 1,
  new Date().getDate()
);

// Flatpickr for ticket page
function ticket() {
  flatpickr("#startDate", {
    altInput: true,
    altFormat: "F j, Y",
    dateFormat: "Y-m-d",
    minDate: "today",
    maxDate: maxDate,
    showMonths: 2,
    locale: {
      firstDayOfWeek: 1,
    },
  });
}

// Flatpickr for hotel page
function hotel() {
  flatpickr("#range1", {
    altInput: true,
    enableTime: false,
    altFormat: "F j, Y",
    dateFormat: "Y-m-d",
    minDate: "today",
    maxDate: maxDate,
    showMonths: 2,
    locale: {
      firstDayOfWeek: 1,
    },
    plugins: [
      new rangePlugin({
        input: "#range2",
      }),
    ],
  });
}

// Decide which function to run based on page
if (document.location.pathname.includes("ticket")) {
  ticket();
} else {
  hotel();
}
