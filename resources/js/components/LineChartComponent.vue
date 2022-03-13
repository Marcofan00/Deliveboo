<script>
import { Bar } from 'vue-chartjs';

export default {
    extends: Bar,
    props: {
        user: Number
    },
    data() {
        return {
            orderTotal: [200.00],
            orderDate: ['2021-01'],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        }
    },
    mounted() {
        this.getAllOrders(this.user);
        
    },
    methods: {
        getAllOrders: async function(id) {
            try {

                let response = await fetch('http://localhost:8000/api/dashboard/statistics/' + id);

                if (response.ok) {
                    let responseToJson = await response.json();

                    console.log(responseToJson);

                    let self = this;

                    responseToJson.forEach(function(order) {
                        self.orderTotal.push(order.total);
                        self.orderDate.push(order.date);
                    });

                    this.renderChart({
                        labels: this.orderDate,
                        datasets: [{
                            label: 'Vendite',
                            backgroundColor: '#FE5E49',
                            data: this.orderTotal
                        }]
                    }, this.options)

                    
                }

            } catch(err) {
                console.log(err);
            }
        }
    }
}
</script>