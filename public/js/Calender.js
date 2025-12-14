/**
 * Pungut-in Dashboard JS
 */

function changeMonth(step, currentMonth, currentYear) {
    const m = currentMonth + step;
    const y = currentYear;
    
    // Calculate new month and year
    // If m < 1 (Jan -> Dec of prev year)
    // If m > 12 (Dec -> Jan of next year)
    
    // Formula: ((m - 1 + 12) % 12) + 1
    // But simpler logic for year change:
    
    let newMonth = m;
    let newYear = y;
    
    if (m < 1) {
        newMonth = 12;
        newYear = y - 1;
    } else if (m > 12) {
        newMonth = 1;
        newYear = y + 1;
    }
    
    location.search = '?month=' + newMonth + '&year=' + newYear;
}
