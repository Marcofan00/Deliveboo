<script>
import { Line } from 'vue-chartjs';

export default {
    extends: Line,
    mounted() {
        this.renderChart({
               labels: [2021, 2022, 2023],
               datasets: [{
                  label: 'Vendite',
                  backgroundColor: '#FC2525',
                  data: [100, 200, 300]
            }]}, {responsive: true, maintainAspectRatio: false})
    }
}
</script>