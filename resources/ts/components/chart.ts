import Chart, { ChartConfiguration } from 'chart.js/auto'
// Import Alpine if using module system, otherwise declare it as global
// import Alpine from 'alpinejs';

declare const Alpine: any;

document.addEventListener('alpine:init', () => {
    Alpine.data('chart', (config: ChartConfiguration) => ({
        init(this: { $refs: { canvas: HTMLCanvasElement } }) {
            // Ensure canvas exists before rendering
            const canvas = this.$refs.canvas as HTMLCanvasElement
            if (canvas) {
                new Chart(canvas, config)
            }
        }
    }))
})
