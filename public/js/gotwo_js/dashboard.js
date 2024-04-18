const xValues = ["Rider: 42", "Customer:45"];
const yValues = [42, 45];
const barColors = [
   "#C34813",
   "#35C096"
];

new Chart("myChart", {
   type: "doughnut",
   data: {
      labels: xValues,
      datasets: [{
         backgroundColor: barColors,
         data: yValues
      }]
   },
   options: {
      title: {
         display: true,
         text: "User use application",
         fontSize: 16
      }

   }
});