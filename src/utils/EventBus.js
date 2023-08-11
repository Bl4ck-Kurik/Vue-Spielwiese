class EventBus {
    constructor() {
    this.events = {};
    }

    // Register an event with a specific name
    on(eventName, callback) {
    if (!this.events[eventName]) {
        this.events[eventName] = [];
    }
    this.events[eventName].push(callback);
    }

    // Emit the event to all listeners
    emit(eventName, ...args) {
    if (this.events[eventName]) {
        this.events[eventName].forEach(callback => {
        callback(...args);
        });
    }
    }

    // Remove the event listeners
    off(eventName, callback) {
    if (this.events[eventName]) {
        const index = this.events[eventName].indexOf(callback);
        if (index > -1) {
        this.events[eventName].splice(index, 1);
        }
    }
    }
}

export default new EventBus();  