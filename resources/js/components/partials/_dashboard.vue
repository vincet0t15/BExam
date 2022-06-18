<template>
<div>
    <div class="right_col" role="main">
        <div class="">
            <canvas id="myChart" width="400" height="400"></canvas>
        </div>
    </div>
</div>
</template>

<script>
import Chart from 'chart.js/auto';
import axios from "axios";
export default {
    data() {
        return {
            expenses: {},
            test: []
        }
    },

    methods: {
        getExpenses() {
            axios
                .get('api/expenses')
                .then(response => (
                    this.expenses = response,
                    response.data.forEach(element => {
                        this.test.push(element.amount)
                    }),
                    console.log(this.test)
                ))
                .catch(err => console.log(err))
        },
    },
    mounted() {

        let test = new Array();

        axios
            .get('api/expenses')
            .then(response => {
                let data = response.data;
                if (data) {
                    data.forEach(element => {
                        test.push(element.amount);
                    });
                    
                }
                console.log(test);
            });

        const ctx = document.getElementById('myChart');

        const data = {
            datasets: [{
                label: 'My First Dataset',
                data: test,
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        };

        const myChart = new Chart(ctx, {
            type: 'pie',
            data: data,

        });
        myChart;
    }
}
</script>
