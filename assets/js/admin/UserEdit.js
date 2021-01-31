import $ from 'jquery';

export default class UserEdit {
    constructor(selector) {
        this.$el = $(document).find(selector);
        this.$form = this.$el.find('form');
    }

    init() {

    }

    onSubmitInit() {
        this.$form.on('submit', this.onSubmit.bind(this));
    }

    onSubmit() {
        let url = this.$form.attr('action');
        if (!this.$form.attr) return false;
    }

}