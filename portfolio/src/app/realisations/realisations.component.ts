import { Component, OnInit, OnDestroy } from '@angular/core';
import { RealisationsContent } from 'src/app/realisations/realisations.enums';
import { Router, ActivatedRoute } from '@angular/router';
import { Subscription } from 'rxjs';


@Component({
  selector: 'Realisations',
  templateUrl: './realisations.component.html',
  styleUrls: ['./realisations.component.scss']
})
export class RealisationsComponent implements OnInit, OnDestroy {
  public lang: string;
  private allRealisations: any = RealisationsContent;
  public realisations: any;
  private subs = new Subscription();

  constructor(
    private router: Router,
    private route: ActivatedRoute
  ) { }

  ngOnInit(): void {
    this.lang = 'fr';
    this.realisations = this.allRealisations[this.lang];
  }

  navigateTo(realisation) {
    this.router.navigateByUrl('/realisation', { state: { realisation } });
  }

  ngOnDestroy() {
    if (this.subs) {
      this.subs.unsubscribe();
    }
  }
}
