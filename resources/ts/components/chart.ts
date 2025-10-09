import Chart, { ChartConfiguration } from 'chart.js/auto';

declare const Alpine: any;

document.addEventListener('alpine:init', () => {
    Alpine.data('chart', (config: ChartConfiguration) => ({
        init(this: { $refs: { canvas: HTMLCanvasElement } }) {
            const canvas = this.$refs.canvas as HTMLCanvasElement
            if (canvas) {
                new Chart(canvas, config)
            }
        }
    }))
})
