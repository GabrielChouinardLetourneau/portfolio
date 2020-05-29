import { Component, OnInit, OnChanges, SimpleChanges } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { RealisationsContent } from 'src/app/realisations/realisations.enums';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

@Component({
  selector: 'realisation-index',
  templateUrl: './realisation-index.component.html',
  styleUrls: ['./realisation-index.component.scss']
})
export class RealisationIndexComponent implements OnInit, OnChanges {

  private state$: Observable<object>;
  public lang: string;
  private allRealisations: any = RealisationsContent;
  public realisationContent: any;

  constructor(
    private activatedRoute: ActivatedRoute,
    private router: Router
  ) { }

  ngOnChanges(changes: SimpleChanges) {
    console.log('ngOnChages?');
  }

  ngOnInit(): void {
    this.state$ = this.activatedRoute.paramMap
      .pipe(map(() =>
        window.history.state
      ));

    if (!window.history.state.realisation) {
      this.router.navigate(['/']);
    }
    else {
      this.lang = 'fr';
      this.allRealisations[this.lang].forEach(e => {
        if (e.Title === window.history.state.realisation) {
          this.realisationContent = e;
        }
      });
    }
  }

  returnHome(): void {
    this.router.navigate(['/']);
  }
}
