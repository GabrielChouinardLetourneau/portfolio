import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, throwError } from 'rxjs';
import { catchError, map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class BackendService {


  constructor(
    private http: HttpClient
  ) { }

  buildAPIUrl(route) {
    // For development
    return `http://localhost:3000/${route}`;
  }

  get(route): Observable<any> {
    return this.http.get(this.buildAPIUrl(route)).pipe(
      map((response) => response),
      catchError(e => {
        return throwError(e);
      })
    );
  }
}
