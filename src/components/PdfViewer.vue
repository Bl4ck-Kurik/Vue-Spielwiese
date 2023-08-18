<template>
    <div class="pdf-wrapper">
        <canvas v-for="(src, index) in src" :key="index" :ref="el => { pdfCanvas[index] = el }"></canvas>
    </div>
</template>

<script>
import { getDocument } from 'pdfjs-dist'
import * as pdfjsLib from 'pdfjs-dist'

pdfjsLib.GlobalWorkerOptions.workerSrc = '/js/pdf.worker.js'

export default {
    name: 'PdfViewer',
    props: {
        src: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            pdfCanvas: [],
            pdfData: []
        };
    },
    methods: {
        async renderPdf(src, index) {
            try {
                console.log("Fetching PDF from:", src)
                const pdf = await getDocument(src).promise
                console.log("Fetched PDF:", pdf)

                this.pdfData[index] = pdf;
                if (pdf.numPages > 0) {
                    const page = await pdf.getPage(1)
                    const viewport = page.getViewport({ scale: 1 })
                    const canvas = this.pdfCanvas[index]
                    const context = canvas.getContext('2d')
                    canvas.height = viewport.height
                    canvas.width = viewport.width
                    page.render({
                        canvasContext: context,
                        viewport: viewport
                    });
                }
            } catch (error) {
                console.error('Error loading PDF:', error)
            }
        },
        setCanvasRef(el) {
            if (el) {
                this.pdfCanvas.push(el)
            }
        }
    },
    mounted() {
        for (let i = 0; i < this.src.length; i++) {
            this.renderPdf(this.src[i], i)
        }
    }
}
</script>

<style>
.pdf-wrapper canvas {
    margin: 10px;
    max-width: 400px;
    max-height: 400px;
}
</style>