function CalendarPicker(element, options) {
    // Core variables.
    this.date = new Date();
    this._formatDateToInit(this.date);

    this.day = this.date.getDay()
    this.month = this.date.getMonth();
    this.year = this.date.getFullYear();

    // Storing the todays date for practical reasons.
    this.today = this.date;

    // The calendars value should always be the current date.
    this.value = this.date;

    // Ranges for the calendar (optional).
    this.min = options.min;
    this.max = options.max;
    this._formatDateToInit(this.min);
    this._formatDateToInit(this.max);

    // Element to insert calendar in.
    this.userElement = document.querySelector(element);

    // Setting current date as readable text.
    this._setDateText();

    // The elements used to build the calendar.
    this.calendarWrapper = document.createElement('div');
    this.calendarElement = document.createElement('div')
    this.calendarHeader = document.createElement('header');
    this.calendarHeaderTitle = document.createElement('h4');
    this.navigationWrapper = document.createElement('section')
    this.previousMonthArrow = document.createElement('button');
    this.nextMonthArrow = document.createElement('button');
    this.calendarGridDays = document.createElement('section')
    this.calendarGrid = document.createElement('section');
    this.calendarDayElementType = 'time';

    var beginningOfYearOnMonday = new Date('2018-01-01');
    var locale = options.locale || 'fr-FR';
    this.listOfAllDaysAsText = [...Array(7).keys()].map(this._toTranslatedWeekday(beginningOfYearOnMonday, locale, options.showShortWeekdays))
    this.listOfAllMonthsAsText = [...Array(12).keys()].map(this._toTranslatedMonth(beginningOfYearOnMonday, locale))

    // Creating the calendar
    this.calendarWrapper.id = 'calendar-wrapper';
    this.calendarElement.id = 'calendar';
    this.calendarGridDays.id = 'calendar-days';
    this.calendarGrid.id = 'calendar-grid';
    this.navigationWrapper.id = 'navigation-wrapper';
    this.previousMonthArrow.id = 'previous-month';
    this.nextMonthArrow.id = 'next-month';

    this._insertHeaderIntoCalendarWrapper();
    this._insertCalendarGridDaysHeader();
    this._insertDaysIntoGrid();
    this._insertNavigationButtons();
    this._insertCalendarIntoWrapper();

    this.userElement.appendChild(this.calendarWrapper);
}

CalendarPicker.prototype._toTranslatedWeekday = function(beginningOfYearOnMonday, locale, showShortWeekdays) {
    var weekdayFormat = showShortWeekdays ? 'short' : 'long'
    return function(dayOfWeekIndex) {
        return new Intl.DateTimeFormat(locale, { weekday: weekdayFormat })
            .format(new Date(beginningOfYearOnMonday.getFullYear(), beginningOfYearOnMonday.getMonth(), beginningOfYearOnMonday.getDate() + dayOfWeekIndex))
    }
}

CalendarPicker.prototype._toTranslatedMonth = function(beginningOfYearOnMonday, locale) {
    return function(monthIndex) {
        return new Intl.DateTimeFormat(locale, { month: 'long' })
            .format(new Date(beginningOfYearOnMonday.getFullYear(), beginningOfYearOnMonday.getMonth() + monthIndex, beginningOfYearOnMonday.getDate()))
    }
}

CalendarPicker.prototype._getDaysInMonth = function (month, year) {
    if ((!month && month !== 0) || (!year && year !== 0)) return;

    var date = new Date(year, month, 1);
    var days = [];

    while (date.getMonth() === month) {
        days.push(new Date(date));
        date.setDate(date.getDate() + 1);
    }
    return days;
}

CalendarPicker.prototype._formatDateToInit = function (date) {
    if (!date) return;
    date.setHours(0, 0, 0);
}

CalendarPicker.prototype._setDateText = function () {
    // Setting current date as readable text.
    var dateData = this.date.toString().split(' ');
    this.dayAsText = dateData[0];
    this.monthAsText = dateData[1];
    this.dateAsText = dateData[2];
    this.yearAsText = dateData[3];
}

CalendarPicker.prototype._insertCalendarIntoWrapper = function () {
    this.calendarWrapper.appendChild(this.calendarElement);

    var handleSelectedElement = (event) => {
        if (event.target.nodeName.toLowerCase() === this.calendarDayElementType && !event.target.classList.contains('disabled')) {

            // Removes the 'selected' class from all elements that have it.
            Array.from(this.calendarGrid.querySelectorAll('.selected')).forEach(element => element.classList.remove('selected'));

            // Adds the 'selected'-class to the selected date.
            event.target.classList.add('selected');

            this.value = event.target.value;

            // Fires the onValueChange function with the provided callback.
            this.onValueChange(this.callback);
        }
    }

    this.calendarGrid.addEventListener('click', handleSelectedElement, false);

    this.calendarGrid.addEventListener('keydown', (keyEvent) => {
        if (keyEvent.key !== 'Enter') return;

        handleSelectedElement(keyEvent);
    }, false);
}

CalendarPicker.prototype._insertHeaderIntoCalendarWrapper = function () {
    this.calendarHeaderTitle.textContent = this.listOfAllMonthsAsText[this.month] + ' - ' + this.year;
    this.calendarHeader.appendChild(this.calendarHeaderTitle);
    this.calendarWrapper.appendChild(this.calendarHeader);
}

CalendarPicker.prototype._insertCalendarGridDaysHeader = function () {
    this.listOfAllDaysAsText.forEach(day => {
        var dayElement = document.createElement('span');
        dayElement.textContent = day;
        this.calendarGridDays.appendChild(dayElement);
    })

    this.calendarElement.appendChild(this.calendarGridDays);
}

CalendarPicker.prototype._insertNavigationButtons = function () {
    // Ugly long string, but at least the svg is pretty.
    var arrowSvg = '<svg enable-background="new 0 0 386.257 386.257" viewBox="0 0 386.257 386.257" xmlns="http://www.w3.org/2000/svg"><path d="m0 96.879 193.129 192.5 193.128-192.5z"/></svg>';

    this.previousMonthArrow.innerHTML = arrowSvg;
    this.nextMonthArrow.innerHTML = arrowSvg;

    this.previousMonthArrow.setAttribute('aria-label', 'Go to previous month');
    this.nextMonthArrow.setAttribute('aria-label', 'Go to next month');

    this._toggleNavigationButtons();

    this.navigationWrapper.appendChild(this.previousMonthArrow);
    this.navigationWrapper.appendChild(this.nextMonthArrow);

    // Cannot use arrow-functions for IE support :(
    var that = this;
    this.navigationWrapper.addEventListener('click', function (clickEvent) {
        if (clickEvent.target.closest('#' + that.previousMonthArrow.id)) {
            if (that.month === 0) {
                that.month = 11;
                that.year -= 1;
            } else {
                that.month -= 1;
            }
            that._updateCalendar();
        }

        if (clickEvent.target.closest('#' + that.nextMonthArrow.id)) {
            if (that.month === 11) {
                that.month = 0;
                that.year += 1;
            } else {
                that.month += 1;
            }
            that._updateCalendar();
        }
    }, false)

    that.calendarElement.appendChild(that.navigationWrapper);
}

CalendarPicker.prototype._beginningOfMonth = function(date) {
    return new Date(date.getFullYear(), date.getMonth())
}

CalendarPicker.prototype._endOfMonth = function(date) {
    return new Date(date.getFullYear(), date.getMonth() + 1);
}

CalendarPicker.prototype._toggleNavigationButtons = function() {
    this.previousMonthArrow.toggleAttribute('disabled', !!this.min && this._beginningOfMonth(this.date) <= this.min);
    this.nextMonthArrow.toggleAttribute('disabled', !!this.max && this._endOfMonth(this.date) >= this.max);
}

CalendarPicker.prototype._insertDaysIntoGrid = function () {
    this.calendarGrid.innerHTML = '';

    var arrayOfDays = this._getDaysInMonth(this.month, this.year);
    var firstDayOfMonth = arrayOfDays[0].getDay();

    // Converting Sunday (0 when using getDay()) to 7 to make it easier to work with.
    firstDayOfMonth = firstDayOfMonth === 0 ? 7 : firstDayOfMonth;

    if (1 < firstDayOfMonth) {
        arrayOfDays = Array(firstDayOfMonth - 1).fill(false, 0).concat(arrayOfDays);
    }

    //console.log(arrayOfDays)
    arrayOfDays.forEach(date => {
        var dateElement = document.createElement(date ? this.calendarDayElementType : 'span');
        var Date = date.toString().split(' ')[2];

        var dateIsTheCurrentValue = this.value.toString() === date.toString();
        if (dateIsTheCurrentValue) this.activeDateElement = dateElement;
    
        //var dateIsBetweenAllowedRange = (this.min || this.max) && (date.toString() !== this.today.toString() && (date < this.min || date > this.max) || (date.toString().split(' ')[0] == "Sat" || date.toString().split(' ')[0] == "Sun"));
        var dateIsBetweenAllowedRange = (this.min || this.max) && (date.toString() !== this.today.toString() && ( date < this.min && date > this.max) || (date.toString().split(' ')[0] == "Sat" || date.toString().split(' ')[0] == "Sun"));

        if (dateIsBetweenAllowedRange) {
            dateElement.classList.add('disabled');
        } else {
            dateElement.tabIndex = 0;
            dateElement.value = date;
        }

        dateElement.textContent = date ? Date : '';
        this.calendarGrid.appendChild(dateElement);
    })

    this.calendarElement.appendChild(this.calendarGrid);
    this.activeDateElement.classList.add('selected');
}

CalendarPicker.prototype._updateCalendar = function () {
    this.date = new Date(this.year, this.month);

    this._setDateText();

    this.day = this.date.getDay();
    this.month = this.date.getMonth();
    this.year = this.date.getFullYear();
    this._toggleNavigationButtons();

    // Cannot use arrow-functions for IE support :(
    var that = this;
    window.requestAnimationFrame(function () {
        that.calendarHeaderTitle.textContent = that.listOfAllMonthsAsText[that.month] + ' - ' + that.year;
        that._insertDaysIntoGrid();
    })
}

CalendarPicker.prototype.onValueChange = function (callback) {
    if (this.callback) return this.callback(this.value);
    this.callback = callback;
}

