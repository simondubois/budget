
const data = () => ({
    colors: {
        blue: {
            light: 'rgba(21, 140, 186, 0.1)',
            medium: 'rgba(21, 140, 186, 0.5)',
            strong: 'rgba(21, 140, 186, 0.9)',
        },
        indigo: {
            light: 'rgba(102, 16, 242, 0.1)',
            medium: 'rgba(102, 16, 242, 0.5)',
            strong: 'rgba(102, 16, 242, 0.9)',
        },
        purple: {
            light: 'rgba(111, 66, 193, 0.1)',
            medium: 'rgba(111, 66, 193, 0.5)',
            strong: 'rgba(111, 66, 193, 0.9)',
        },
        pink: {
            light: 'rgba(232, 62, 140, 0.1)',
            medium: 'rgba(232, 62, 140, 0.5)',
            strong: 'rgba(232, 62, 140, 0.9)',
        },
        red: {
            light: 'rgba(255, 65, 54, 0.1)',
            medium: 'rgba(255, 65, 54, 0.5)',
            strong: 'rgba(255, 65, 54, 0.9)',
        },
        orange: {
            light: 'rgba(253, 126, 20, 0.1)',
            medium: 'rgba(253, 126, 20, 0.5)',
            strong: 'rgba(253, 126, 20, 0.9)',
        },
        yellow: {
            light: 'rgba(255, 133, 27, 0.1)',
            medium: 'rgba(255, 133, 27, 0.5)',
            strong: 'rgba(255, 133, 27, 0.9)',
        },
        green: {
            light: 'rgba(40, 182, 44, 0.1)',
            medium: 'rgba(40, 182, 44, 0.5)',
            strong: 'rgba(40, 182, 44, 0.9)',
        },
        teal: {
            light: 'rgba(32, 201, 151, 0.1)',
            medium: 'rgba(32, 201, 151, 0.5)',
            strong: 'rgba(32, 201, 151, 0.9)',
        },
        cyan: {
            light: 'rgba(117, 202, 235, 0.1)',
            medium: 'rgba(117, 202, 235, 0.5)',
            strong: 'rgba(117, 202, 235, 0.9)',
        },
        gray1: {
            light: 'rgba(246, 246, 246, 0.1)',
            medium: 'rgba(246, 246, 246, 0.5)',
            strong: 'rgba(246, 246, 246, 0.9)',
        },
        gray2: {
            light: 'rgba(240, 240, 240, 0.1)',
            medium: 'rgba(240, 240, 240, 0.5)',
            strong: 'rgba(240, 240, 240, 0.9)',
        },
        gray3: {
            light: 'rgba(222, 226, 230, 0.1)',
            medium: 'rgba(222, 226, 230, 0.5)',
            strong: 'rgba(222, 226, 230, 0.9)',
        },
        gray4: {
            light: 'rgba(206, 212, 218, 0.1)',
            medium: 'rgba(206, 212, 218, 0.5)',
            strong: 'rgba(206, 212, 218, 0.9)',
        },
        gray5: {
            light: 'rgba(173, 181, 189, 0.1)',
            medium: 'rgba(173, 181, 189, 0.5)',
            strong: 'rgba(173, 181, 189, 0.9)',
        },
        gray6: {
            light: 'rgba(153, 153, 153, 0.1)',
            medium: 'rgba(153, 153, 153, 0.5)',
            strong: 'rgba(153, 153, 153, 0.9)',
        },
        gray7: {
            light: 'rgba(85, 85, 85, 0.1)',
            medium: 'rgba(85, 85, 85, 0.5)',
            strong: 'rgba(85, 85, 85, 0.9)',
        },
        gray8: {
            light: 'rgba(51, 51, 51, 0.1)',
            medium: 'rgba(51, 51, 51, 0.5)',
            strong: 'rgba(51, 51, 51, 0.9)',
        },
        gray9: {
            light: 'rgba(34, 34, 34, 0.1)',
            medium: 'rgba(34, 34, 34, 0.5)',
            strong: 'rgba(34, 34, 34, 0.9)',
        },
    },
});

const methods = {
    formControlClass(field) {
        return {
            'is-valid': Object.keys(this.errors).length && this.errors[field] === undefined,
            'is-invalid': this.errors[field],
        };
    },
    makeMoney: amounts => new (require('./money.js').default)(amounts),
};

export {
    data,
    methods,
};
