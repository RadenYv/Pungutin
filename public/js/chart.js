/**
 * ============================================================
 * PUNGUT-IN - Order Status Donut Chart
 * ============================================================
 * This script initializes a Chart.js donut chart displaying
 * the distribution of pickup order statuses.
 * 
 * Dependencies: Chart.js 4.x
 * ============================================================
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Get the canvas element where the chart will be rendered
    const ctx = document.getElementById('orderStatusChart');
    
    // Exit if canvas element doesn't exist (not on dashboard page)
    if (!ctx) return;

    // ==========================================
    // DATA CONFIGURATION
    // ==========================================
    
    // Get data from data attributes on the canvas element
    const chartData = ctx.dataset;
    
    // Status labels matching the database ENUM values
    const statusLabels = [
        'Menunggu',      // Waiting for pickup
        'Dalam Batch',   // Assigned to a batch
        'Dijemput',      // Currently being picked up
        'Selesai'        // Completed
    ];

    // Actual data values from data attributes
    const statusData = [
        parseInt(chartData.menunggu) || 0,
        parseInt(chartData.batch) || 0,
        parseInt(chartData.jemput) || 0,
        parseInt(chartData.selesai) || 0
    ];

    // Pull status colors from CSS variables so chart matches theme + status system
    const rootStyles = getComputedStyle(document.documentElement);
    const cssVar = (name) => rootStyles.getPropertyValue(name).trim();

    const statusColors = [
        cssVar('--status-menunggu'),
        cssVar('--status-batch'),
        cssVar('--status-jemput'),
        cssVar('--status-selesai')
    ];

    // Same colors with brightness boost for hover (handled via opacity in CSS — use hex with alpha)
    const statusHoverColors = statusColors.slice();

    // ==========================================
    // CHART CONFIGURATION
    // ==========================================
    
    new Chart(ctx, {
        type: 'doughnut',  // Donut chart (doughnut with center cutout)
        
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData,
                backgroundColor: statusColors,
                hoverBackgroundColor: statusHoverColors,
                borderWidth: 0,           // No border between segments
                borderRadius: 6,          // Rounded arc edges for modern look
                hoverBorderWidth: 0,      // No border on hover
                hoverOffset: 8            // Slight expansion on hover
            }]
        },
        
        options: {
            // Make chart responsive to container size
            responsive: true,
            maintainAspectRatio: true,
            
            // Size of the center hole (0 = pie, 1 = ring)
            cutout: '80%',
            
            // Disable default legend (we use custom HTML legend)
            plugins: {
                legend: {
                    display: false
                },
                
                // Tooltip configuration for hover information
                tooltip: {
                    enabled: false, // Disable canvas tooltip
                    
                    // Use external HTML tooltip to render outside canvas
                    external: function(context) {
                        // Tooltip Element
                        let tooltipEl = document.getElementById('chartjs-tooltip');

                        // Create element on first render
                        if (!tooltipEl) {
                            tooltipEl = document.createElement('div');
                            tooltipEl.id = 'chartjs-tooltip';
                            document.body.appendChild(tooltipEl);
                        }

                        // Hide if no tooltip
                        const tooltipModel = context.tooltip;
                        if (tooltipModel.opacity === 0) {
                            tooltipEl.style.opacity = 0;
                            return;
                        }

                        // Set Text
                        if (tooltipModel.body) {
                            const bodyLines = tooltipModel.body.map(b => b.lines);

                            let innerHtml = '';

                            bodyLines.forEach(function(body, i) {
                                const colors = tooltipModel.labelColors[i];
                                const span = '<span style="display:inline-block;width:10px;height:10px;background:' + colors.backgroundColor + ';border-radius:2px;margin-right:8px;"></span>';
                                innerHtml += '<div style="display:flex;align-items:center;">' + span + body + '</div>';
                            });

                            tooltipEl.innerHTML = innerHtml;
                        }

                        const position = context.chart.canvas.getBoundingClientRect();

                        // Display, position, and set styles
                        tooltipEl.style.opacity = 1;
                        tooltipEl.style.position = 'absolute';
                        tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX + 'px';
                        tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY + 'px';
                        tooltipEl.style.fontFamily = 'system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial';
                        tooltipEl.style.fontSize = '12px';
                        tooltipEl.style.padding = '8px 12px';
                        tooltipEl.style.pointerEvents = 'none';
                        tooltipEl.style.zIndex = 1000;
                        tooltipEl.style.backgroundColor = '#1a1a1a';
                        tooltipEl.style.border = '1px solid rgba(255,255,255,0.1)';
                        tooltipEl.style.borderRadius = '8px';
                        tooltipEl.style.color = '#e6edf3';
                        tooltipEl.style.transform = 'translate(-50%, -100%) translateY(-10px)'; // Move above cursor
                        tooltipEl.style.transition = 'opacity .1s ease';
                        tooltipEl.style.boxShadow = '0 4px 6px rgba(0,0,0,0.3)';
                    },
                    
                    // Custom tooltip callbacks
                    callbacks: {
                        // Add percentage to tooltip
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const value = context.raw;
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return `${context.label}: ${value} (${percentage}%)`;
                        },
                        title: function() {
                            return ''; // No title
                        }
                    }
                }
            },
            
            // Animation configuration
            animation: {
                animateRotate: true,      // Rotate animation on load
                animateScale: true,       // Scale animation on load
                duration: 800,            // Animation duration in ms
                easing: 'easeOutQuart'    // Smooth easing function
            },
            
            // Layout padding
            layout: {
                padding: 10
            }
        }
    });
});

// ==========================================
// BATCH STATUS BAR CHART
// ==========================================

document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('batchStatusChart');
    
    if (!ctx) return;

    const chartData = ctx.dataset;
    
    const batchLabels = ['Pending', 'Ditugaskan', 'Berjalan', 'Selesai'];
    const batchData = [
        parseInt(chartData.pending) || 0,
        parseInt(chartData.tugas) || 0,
        parseInt(chartData.berjalan) || 0,
        parseInt(chartData.selesai) || 0
    ];

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: batchLabels,
            datasets: [{
                label: 'Batch Count',
                data: batchData,
                backgroundColor: [
                    'rgba(255, 193, 7, 0.8)',   // Pending - Yellow
                    'rgba(13, 110, 253, 0.8)',  // Ditugaskan - Blue
                    'rgba(163, 113, 247, 0.8)', // Berjalan - Purple
                    'rgba(25, 135, 84, 0.8)'    // Selesai - Green
                ],
                borderColor: [
                    'rgba(255, 193, 7, 1)',
                    'rgba(13, 110, 253, 1)',
                    'rgba(163, 113, 247, 1)',
                    'rgba(25, 135, 84, 1)'
                ],
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.9)',
                    titleColor: '#e6edf3',
                    bodyColor: '#e6edf3',
                    borderColor: '#30363d',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' batch';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#8b949e',
                        font: {
                            size: 11
                        },
                        stepSize: 1
                    },
                    grid: {
                        color: 'rgba(48, 54, 61, 0.5)',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: '#8b949e',
                        font: {
                            size: 12,
                            weight: '500'
                        }
                    },
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            }
        }
    });
});
