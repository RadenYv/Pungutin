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

    // Color palette matching the dashboard theme
    // Each color corresponds to a status in order
    const statusColors = [
        '#ffc107',  // Menunggu (warning/pending)
        '#6c757d',  // Dalam Batch (secondary/queued)
        '#0d6efd',  // Dijemput (primary/in-progress)
        '#198754'   // Selesai (success/completed)
    ];

    // Brighter colors for hover effect
    // Increases visibility when user hovers over segments
    const statusHoverColors = [
        '#ffda6a',  // Lighter yellow
        '#8c939a',  // Lighter gray
        '#4d94ff',  // Lighter blue
        '#28a745'   // Lighter green
    ];

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
            cutout: '70%',
            
            // Disable default legend (we use custom HTML legend)
            plugins: {
                legend: {
                    display: false
                },
                
                // Tooltip configuration for hover information
                tooltip: {
                    enabled: true,
                    backgroundColor: '#1a1a1a',
                    titleColor: '#ffffff',
                    bodyColor: '#e6edf3',
                    borderColor: 'rgba(255,255,255,0.1)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 12,
                    displayColors: true,
                    boxPadding: 6,
                    
                    // Custom tooltip callbacks
                    callbacks: {
                        // Add percentage to tooltip
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const value = context.raw;
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return ` ${context.label}: ${value} (${percentage}%)`;
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
