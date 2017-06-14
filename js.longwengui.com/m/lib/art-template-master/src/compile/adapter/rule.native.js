/**
 * 原生模板语法规则
 */
const nativeRule = {
    test: /<%(#?)((?:==|=#|[=-])?)([\w\W]*?)(-?)%>/,
    use: (match, comment, output, code/*, trimMode*/) => {

        output = ({
            '-': 'raw',
            '=': 'escape',
            '': false,
            // v3 compat: raw output
            '==': 'raw',
            '=#': 'raw',
        })[output];

        // ejs compat: comment tag
        if (comment) {
            code = `/*${match}*/`;
            output = false;
        }

        // ejs compat: trims following newline
        // if (trimMode) {}

        return {
            code,
            output
        };

    }
};


module.exports = nativeRule;