
export default class Money {

    constructor(amounts) {
        this.amounts = amounts;
    }

    add(that) {
        return new Money(
            Object.keys({ ...this.amounts, ...that.amounts }).reduce((result, key) => {
                result[key] = (this.amounts ? this.amounts[key] : 0) + (that.amounts ? that.amounts[key] : 0);
                return result;
            }, {})
        );
    }

    getContext(currency) {
        if (this.getNumber(currency) > 0) {
            return 'success';
        }
        if (this.getNumber(currency) < 0) {
            return 'danger';
        }
        return 'light';
    }

    getIcon(currency) {
        if (this.getNumber(currency) > 0) {
            return 'positive';
        }
        if (this.getNumber(currency) < 0) {
            return 'negative';
        }
        return 'null';
    }

    getNumber(currency) {
        if (this.amounts === undefined) {
            return 0;
        }
        return this.amounts[currency.iso]
    }

    getText(currency) {
        return new Intl.NumberFormat(window.app.$i18n ? window.app.$i18n.locale : 'en')
            .format(this.getNumber(currency)) + ' ' + currency.unit;
    }

    makeOpposite() {
        if (this.amounts === undefined) {
            return new Money();
        }
        return new Money(
            Object.keys(this.amounts).reduce((opposite, key) => {
                opposite[key] = -this.amounts[key];
                return opposite;
            }, {})
        );
    }

    subtract(that) {
        return new Money(
            Object.keys({ ...this.amounts, ...that.amounts }).reduce((result, key) => {
                result[key] = (this.amounts ? this.amounts[key] : 0) - (that.amounts ? that.amounts[key] : 0);
                return result;
            }, {})
        );
    }

}
