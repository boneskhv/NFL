import urllib.request
import sqlite3

def ParseStanding():
    response = urllib.request.urlopen('http://espn.go.com/nfl/standings')
    html = response.read()
    response.close

    print(html)

    bd = sqlite3.connect("NFL.db")

    bd.execute("drop table if exists standings")
    bd.commit()

    bd.execute('CREATE TABLE standings(team, pct, pf, pa)')
    bd.commit()
    bd.close()

    from bs4 import BeautifulSoup
    soup = BeautifulSoup(html,'html.parser')

    #find tout les nom de team
    links = soup.find_all('span',class_='team-names')
    i = 0
    for link in links:
        names = link.contents[0]
        #fulllink = link.get('')

        if(names.string != None):
            print(names.string)
            #print(fulllink)

            #find tout les scores pour chaque team
            #links2 = soup.find_all('td',class_='')
            links2 = soup.findAll('tr')[i].find_all('td')
            BDStanding(names, links2[4].contents[0], links2[9].contents[0], links2[10].contents[0])
            for link2 in links2:
                stat = link2.contents[0]


                if(stat.string != None):
                    print(stat.string)

        #indice pour trouver le score associer avec la bonne team
        i = i + 1
        print('\n')

    #BD()


def BDStanding(team, pct, pf, pa):
    bd = sqlite3.connect("NFL.db")

    bd.execute("INSERT INTO standings VALUES (?,?,?,?)",(team, pct, pf, pa))
    bd.commit()
    bd.close()




def ParseSchedule():
    bd = sqlite3.connect("NFL.db")

    bd.execute("drop table if exists schedule")
    bd.commit()

    bd.execute('CREATE TABLE schedule(team1, team2, score1, score2)')
    bd.commit()


    for i in range(1,17+1):
        response = urllib.request.urlopen('http://espn.go.com/nfl/schedule/_/week/' + str(i))
        print('http://espn.go.com/nfl/schedule /_/week/' + str(i))
        html = response.read()
        response.close

        print(html)


        test = False
        from bs4 import BeautifulSoup
        soup = BeautifulSoup(html,'html.parser')

        #find tout les nom de team
        links = soup.find_all('a',class_='team-name')
        j = 0
        for link in links:
            names = link.contents[0]
            #fulllink = link.get('')

            if(names.string != None):
                print(names.string)
                #print(fulllink)

                #find tout les scores pour chaque team
                links2 = soup.findAll('tr')[j].find_all('td')
                #BDSchedule(names, links2[4].contents[0], links2[9].contents[0], links2[10].contents[0])
                for link2 in links2:
                    stat = link2.contents[0]
                    #print(link2)

                    if(stat.string != None):
                        print(stat.string)

            #indice pour trouver le score associer avec la bonne team
            #if test:
            j = j + 1

            #test = not(test)
            print('\n')

    bd.close()


def BDSchedule(team1, team2, score1, score2):
    bd = sqlite3.connect("NFL.db")

    bd.execute("INSERT INTO schedule VALUES (?,?,?,?)",(team1, team2, score1, score2))
    bd.commit()
    bd.close()

ParseSchedule()