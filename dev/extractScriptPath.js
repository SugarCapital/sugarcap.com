const fs = require('fs');
const htmlparser = require('htmlparser2');

const isInteresting = function isInteresting(uri) {
  return !(uri.startsWith('http') || uri.startsWith('//') || uri.includes('<?= $this->version'));
}

const extractScriptPaths = function extractScriptPaths(filePath) {
  const stream = fs.createReadStream(filePath);
  const paths = [];
  const promise = new Promise((resolve) => {
    const parser = new htmlparser.Parser({
      onopentag: function(name, attribs){
        if(name === 'script' && 'src' in attribs && isInteresting(attribs.src)) {
          paths.push(attribs.src);
        }
      },
      onend() {
        resolve(paths);
      }
    }, { decodeEntities: true });
    stream.pipe(parser);
  });

  return promise.then(results => JSON.stringify(results.map(e =>  'public' + e)));
};

module.exports = extractScriptPaths;


// extractScriptPaths('./templates/js-bot.tpl')
//   .then(console.log)
//   .catch(console.error);
