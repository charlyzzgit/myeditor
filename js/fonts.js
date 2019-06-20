'use strict'
var fuentes = [
            'Verdana', 
            'Geneva', 
            'Sans-serif',
            'Georgia', 
            'Times New Roman', 
            'Times',
            'Serif',
            'Courier New',
            'Courier', 
            'Monospace',
            'Helvetica', 
            'Tahoma',
            'Trebuchet MS', 
            'Arial', 
            'Arial Black', 
            'Gadget',
            'Palatino Linotype', 
            'Book Antiqua', 
            'Palatino',
            'Lucida Sans Unicode', 
            'Lucida Grande',
            'MS Serif', 
            'New York',
            'Lucida Console', 
            'Monaco',
            'Comic Sans MS', 
            'Cursive',
            'Rockwell Extra Bold'
    ].sort()

function getFonts(){
    var fonts = []
    for(var i = 0; i < fuentes.length; i++){
        fonts.push({name: fuentes[i], value:fuentes[i]})
    }
    return fonts
}

function getFont(index){
      return fuentes[index]
}

function getFontIndex(name){
   var index = -1
   for(var i = 0; i < fuentes.length; i++){
       ver(['font --->', fuentes[i].toLowerCase(), name.replace(/['"]+/g, '')])
      if(fuentes[i] == name.replace(/['"]+/g, '')){
            index = i
            break
      }
   }
   return index
}