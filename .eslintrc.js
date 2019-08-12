// http://eslint.org/docs/user-guide/configuring

module.exports = {
    "env": {
        "node": true
    },
    "extends": [
        "plugin:vue/recommended",
        "eslint:recommended",
    ],
    rules: {
        "vue/html-indent": ["error", 4],
        "vue/multiline-html-element-content-newline": ["error", { "allowEmptyLines": true }],
    }
}
