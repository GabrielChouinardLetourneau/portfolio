import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, RouterStateSnapshot } from '@angular/router';

@Injectable({ providedIn: 'root' })
export class TwitchAuthGuard implements CanActivate {
  constructor() { }

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
    if (!JSON.parse(localStorage.getItem('auth'))) {
      document.location.href = 'http://localhost:3000/auth/twitch';
      localStorage.setItem('auth', JSON.stringify(true));
    }
    else {
      return true;
    }
  }
}
