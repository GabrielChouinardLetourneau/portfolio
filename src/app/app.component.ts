import { Component, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import { Router, NavigationStart, ActivatedRouteSnapshot, ActivatedRoute } from '@angular/router';
import { filter, map } from 'rxjs/operators';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {

  constructor(public router: Router) { }

  ngOnInit() {
    this.router.events.pipe(
      filter(t => t instanceof NavigationStart && (<NavigationStart> t).navigationTrigger === 'popstate' ))
    .subscribe((x: NavigationStart) => {
      this.router.navigate([x.url], { state: x.restoredState });
    });
  }
}
