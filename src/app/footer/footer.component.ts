import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'footer-component',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.scss']
})
export class FooterComponent implements OnInit {
  emailstring;

  constructor() { }

  ngOnInit(): void {
    this.emailstring = 'mailto:chouinardletourneau@gmail.com';
  }


  public contactCourriel() {
    window.location.href = this.emailstring;
  }

}
