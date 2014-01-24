DOCS=home utilities refresh update-solr update-mobiledb flush-cache memcached-stats tasks

HDOCS=$(addsuffix .php, $(DOCS))

.PHONY : docs
docs : $(HDOCS)

%.php : %.jemdoc MENU
	jemdoc -o $@ $<

.PHONY : clean
clean :
	-rm -f home.php utilities.php refresh.php update-solr.php update-mobiledb.php flush-cache.php memcached-stats.php tasks.php
