import { Component, OnInit, Sanitizer } from '@angular/core';
import { FormControl, FormGroup } from '@angular/forms';
import { DomSanitizer } from '@angular/platform-browser';
import { ActivatedRoute, Router } from '@angular/router';
import { of, Subscriber, Subscription } from 'rxjs';
import { BackendService } from 'src/app/backend/backend.service';
import { EnumResultType } from './results.enum';

@Component({
  selector: 'SandboxComponent',
  templateUrl: `./sandbox.component.html`,
  styleUrls: [`./sandbox.component.scss`]
})
export class SandboxComponent implements OnInit {

  public authDone = false;
  public results: any;
  public EnumResultType: EnumResultType;
  public typeResult: EnumResultType;
  public renderReady: boolean;
  public form: FormGroup;
  private subs: Subscription;

  constructor(
    private backendService: BackendService,
    private router: Router,
    private sanitizer: DomSanitizer

  ) { }

  ngOnInit() {
    this.form = new FormGroup({
      searchChannel: new FormControl(null),
      gameClips: new FormControl(null)
    });

    // Subscription management

    // Search a channel
    // this.subs.add(
    //   this.backendService.get(`searchChannel`).subscribe((res) => {
    //     this.renderReady = false;

    //     // TO DO: Error management
    //     console.log(res);
    //     this.renderReady = true;
    //   })
    // );
  }

  fetchTopGames() {
    // Refactor before prod
    // this.renderReady = false;
    this.backendService.get(`topGamesOnTwitch`).subscribe((res) => {
      // TO DO: Error management
      this.typeResult = EnumResultType.TopGames;
      this.results = res.data;
      this.results.forEach(game => {
        const newSrc = game.box_art_url.replace(/{width}x{height}/i, '138x190');
        game.box_art_url = newSrc;
      });
      this.renderReady = true;
    });
  }

  searchChannel(e) {
    // this.renderReady = false;

    this.backendService.get(`searchChannel/${e.target.value}`).subscribe((res) => {
      this.typeResult = EnumResultType.SearchChannel;
      // TO DO: Error management
      this.results = res.data[0];
      console.log(this.results);
      this.renderReady = true;
    });
  }

  getGameClips(e) {
    // this.renderReady = false;
    this.backendService.get(`game-clips/${e.target.value}`).subscribe((res) => {
      this.typeResult = EnumResultType.GameClips;
      // TO DO: Error management

      // res.data.forEach(game => {
      //   const url = game.embed_url + '&parent=127.0.0.1';
      //   console.log(url);
      //   game.embed_url = this.sanitizer.bypassSecurityTrustUrl(url);
      // });

      this.results = res.data;
      this.renderReady = true;
    });
  }

  // sanitizeURL(e) {
  //   const url = e.embed_url + '&parent=127.0.0.1';
  //   console.log(url);
  //   return this.sanitizer.bypassSecurityTrustUrl(url);
  // }
}
