jira-log-work-emacs-diary
=========================

Dumb script for read your diary file and log the hours into JIRA

Cargar las horas mediante una interaz web es algo bastante doloroso, asi que escribi este script que lee mi 
archivo [diary](http://www.gnu.org/software/emacs/manual/html_node/emacs/Diary.html), y carge las entradas correspondientes al mes anterior de la ejecucion del script.

Esta pensado para usarse mediantecron todos los primeros de cada mes

El formato de el archivo diary es muy parecido a esto:


`Aug 29, 2013 Alguna descripcion de lo que hize`

.
Otra cosa importate es que siempre cargo mis horas para un mismo proyecto, y siempre la misma cantidad de horas.
