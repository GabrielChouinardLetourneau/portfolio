import { Pipe, PipeTransform } from '@angular/core';
import { DomSanitizer } from '@angular/platform-browser';

@Pipe({
  name: 'safe'
})
export class SanitizePipe implements PipeTransform {

  constructor(private sanitizer: DomSanitizer) { }
  transform(url) {
    // change the parent
    return this.sanitizer.bypassSecurityTrustResourceUrl(url + '&parent=locahost');
  }

}
